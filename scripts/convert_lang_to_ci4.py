from pathlib import Path
import re

root = Path(__file__).resolve().parent.parent
src = root / 'application' / 'language' / 'english' / 'english_lang.php'
if not src.exists():
    raise FileNotFoundError(f'Legacy language file not found: {src}')
text = src.read_text(encoding='utf-8')
pattern = re.compile(r"^\s*\$lang\[['\"](?P<key>.*?)['\"]\]\s*=\s*['\"](?P<value>.*?)['\"]\s*;\s*$")
entries = []
for line in text.splitlines():
    m = pattern.match(line)
    if m:
        entries.append((m.group('key'), m.group('value')))

if not entries:
    raise ValueError('No language entries parsed from source file.')

out_dir = root / 'ci4-scaffold' / 'Language'
out_dir.mkdir(parents=True, exist_ok=True)
out_file = out_dir / 'english_lang.php'
with out_file.open('w', encoding='utf-8', newline='\n') as f:
    f.write('<?php\n')
    f.write('// Upgraded English language strings from legacy CI3 application/language/english/english_lang.php\n')
    f.write('return [\n')
    for key, value in entries:
        safe_value = value.replace('\\', '\\\\').replace("'", "\\'")
        f.write(f"    '{key}' => '{safe_value}',\n")
    f.write('];\n')

print(f'Created {out_file}')
