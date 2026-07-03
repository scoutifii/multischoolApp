$regexes = @{
    'create_function' = 'create_function\s*\(';
    'extract' = '\bextract\s*\(';
    'eval' = '\beval\s*\(';
    'preg_e' = 'preg_replace\s*\(.*?/e';
}

New-Item -Path migration-previews -ItemType Directory -Force | Out-Null
$i = 1
Get-ChildItem -Recurse -Filter *.php | ForEach-Object {
    $path = $_.FullName
    $content = $null
    # Try common encodings
    foreach ($enc in @('UTF8','Unicode','Default')) {
        try {
            $content = Get-Content -Raw -Encoding $enc -ErrorAction Stop -Path $path
            break
        } catch {
        }
    }
    if ($null -eq $content) { return }

    foreach ($k in $regexes.Keys) {
        if ($content -match $regexes[$k]) {
            # find all matching lines
            $lines = $content -split "\r?\n"
            for ($ln=0; $ln -lt $lines.Length; $ln++) {
                if ($lines[$ln] -match $regexes[$k]) {
                    $lineNo = $ln + 1
                    $lineText = $lines[$ln].Trim()
                    $leaf = (Split-Path $path -Leaf) -replace '[^0-9A-Za-z_.-]','_'
                    $patchFile = "migration-previews/{0:000}_{1}_L{2}.patch" -f $i, $leaf, $lineNo
                    switch ($k) {
                        'create_function' { $suggest = "// SUGGESTION: Convert to anonymous function or named function. Example: $fn = function(args) { /* body */ };" }
                        'extract' { $suggest = "// SUGGESTION: Avoid extract(); assign explicitly: \$var = \$arr['var'] ?? null;" }
                        'eval' { $suggest = "// SUGGESTION: Avoid eval(); refactor to use callbacks or parsing. Review carefully." }
                        'preg_e' { $suggest = "// SUGGESTION: preg_replace with /e is deprecated. Use preg_replace_callback(). Example: preg_replace_callback('/pattern/', function(\$matches){ return /*...*/; }, \$subject);" }
                    }
                    $contentOut = @"
File: $path
Line: $lineNo
Original: $lineText

Patch Preview:
---
- $lineText
+ // [MIGRATION PREVIEW] original line commented out
+ $suggest
"@
                    Set-Content -Path $patchFile -Value $contentOut -Encoding UTF8
                    $i++
                }
            }
        }
    }
}

Write-Output "Created $($i-1) preview patches in migration-previews/"
