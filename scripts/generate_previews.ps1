$matches = Select-String -Path **\*.php -Pattern 'create_function\(|\bextract\s*\(|\beval\s*\(|preg_replace\s*\(.*\/e' -AllMatches
New-Item -Path migration-previews -ItemType Directory -Force | Out-Null
$i = 1
foreach ($m in $matches) {
    $file = $m.Path
    $lineNo = $m.LineNumber
    $lineText = $m.Line.Trim()
    $leaf = (Split-Path $file -Leaf) -replace '[^0-9A-Za-z_.-]','_'
    $patchFile = "migration-previews/{0:000}_{1}_L{2}.patch" -f $i, $leaf, $lineNo

    if ($m.Matches[0].Value -match 'create_function') {
        $suggest = "// SUGGESTION: Convert to anonymous function or named function. Example: $fn = function(args) { /* body */ };"
    } elseif ($m.Matches[0].Value -match '\\bextract\\s*\\(') {
        $suggest = "// SUGGESTION: Avoid extract(); assign explicitly: $var = $arr['var'] ?? null;"
    } elseif ($m.Matches[0].Value -match '\\beval\\s*\\(') {
        $suggest = "// SUGGESTION: Avoid eval(); refactor to use callbacks or parsing. Review carefully."
    } else {
        $suggest = "// SUGGESTION: preg_replace with /e is deprecated. Use preg_replace_callback(). Example: preg_replace_callback('/pattern/', function($matches){ return /*...*/; }, $subject);"
    }

    $content = @"
File: $file
Line: $lineNo
Original: $lineText

Patch Preview:
---
- $lineText
+ // [MIGRATION PREVIEW] original line commented out
+ $suggest
"@

    Set-Content -Path $patchFile -Value $content -Encoding UTF8
    $i++
}

Write-Output "Created $($i-1) preview patches in migration-previews/"
