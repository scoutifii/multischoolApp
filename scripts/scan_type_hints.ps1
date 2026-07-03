cd c:\wamp64\www\multischool

# Extract type-hint issues from the PHP8 scan
$typeHintIssues = Select-String -Path php8_scan_output_utf8.txt -Pattern 'double type hint should be float|Avoid int\(\) cast, use \(int\)|array_key_exists with null values'

# Create output report
$report = @"
TYPE-HINT AND CAST ISSUES - PRIORITIZED LIST
============================================================

CATEGORY 1: double -> float (HIGH PRIORITY)
---
These are easy, systematic replacements. Replace 'double' keyword with 'float'.
Impact: Low risk, high confidence replacements.

Count: $(($typeHintIssues | Where-Object { $_ -match 'double type hint' } | Measure-Object).Count)

Files:
"@

$typeHintIssues | Where-Object { $_ -match 'double type hint' } | ForEach-Object { 
    $report += "`n$($_)"
}

$report += @"


CATEGORY 2: int() casts -> (int) (MEDIUM PRIORITY)
---
Replace intval() and int() casts with native (int) type cast.
Impact: Low risk, semantically equivalent.

Count: $(($typeHintIssues | Where-Object { $_ -match 'Avoid int\(\)' } | Measure-Object).Count)

Files:
"@

$typeHintIssues | Where-Object { $_ -match 'Avoid int\(\)' } | ForEach-Object { 
    $report += "`n$($_)"
}

$report += @"


CATEGORY 3: array_key_exists with null (MEDIUM PRIORITY)
---
array_key_exists() will emit deprecation warning when key exists but value is NULL.
Fix: Use isset() or null-safe operator (?->). Requires code review.

Count: $(($typeHintIssues | Where-Object { $_ -match 'array_key_exists' } | Measure-Object).Count)

Files:
"@

$typeHintIssues | Where-Object { $_ -match 'array_key_exists' } | ForEach-Object { 
    $report += "`n$($_)"
}

$report | Set-Content type_hint_issues_report.txt -Encoding UTF8
Write-Output "Report written to type_hint_issues_report.txt"
