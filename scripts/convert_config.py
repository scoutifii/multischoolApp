from pathlib import Path
import re

root = Path(__file__).resolve().parent.parent
src = root / 'application' / 'config' / 'config.php'
if not src.exists():
    raise FileNotFoundError(f'Legacy config file not found: {src}')
text = src.read_text(encoding='utf-8')

config = {}
constants = {}

# parse config values
pattern = re.compile(r"^\s*\$config\[['\"](?P<key>[^'\"]+)['\"]\]\s*=\s*(?P<value>.+?);\s*$")
for line in text.splitlines():
    match = pattern.match(line)
    if not match:
        continue
    key = match.group('key')
    raw = match.group('value').strip()
    if raw.lower() == 'false':
        value = False
    elif raw.lower() == 'true':
        value = True
    elif raw.isdigit():
        value = int(raw)
    elif re.match(r"^0[0-7]+$", raw):
        value = int(raw, 8)
    elif raw.startswith("array(") and raw.endswith(")"):
        if raw == 'array()':
            value = []
        else:
            # simple array parser for current file usage
            inner = raw[len('array('):-1].strip()
            if inner == '':
                value = []
            else:
                elements = [x.strip() for x in inner.split(',') if x.strip()]
                parsed = []
                for e in elements:
                    if e.lower() == 'false':
                        parsed.append(False)
                    elif e.lower() == 'true':
                        parsed.append(True)
                    elif e.startswith("'") or e.startswith('"'):
                        parsed.append(e[1:-1])
                    elif e.isdigit():
                        parsed.append(int(e))
                    else:
                        parsed.append(e)
                value = parsed
    elif (raw.startswith("'") and raw.endswith("'")) or (raw.startswith('"') and raw.endswith('"')):
        value = raw[1:-1]
    else:
        value = raw
    config[key] = value

# parse defines
pattern_def = re.compile(r"^\s*define\(\s*['\"](?P<key>[^'\"]+)['\"]\s*,\s*(?P<value>.+?)\s*\);\s*$")
for line in text.splitlines():
    match = pattern_def.match(line)
    if not match:
        continue
    key = match.group('key')
    raw = match.group('value').strip()
    if raw.lower() == 'false':
        value = False
    elif raw.lower() == 'true':
        value = True
    elif raw.isdigit():
        value = int(raw)
    elif re.match(r"^0[0-7]+$", raw):
        value = int(raw, 8)
    elif (raw.startswith("'") and raw.endswith("'")) or (raw.startswith('"') and raw.endswith('"')):
        value = raw[1:-1]
    else:
        value = raw
    constants[key] = value

import pprint
export_config = pprint.pformat(config, indent=4, width=120)
export_constants = pprint.pformat(constants, indent=4, width=120)

out_config = f"<?php\nnamespace Config;\n\nuse CodeIgniter\\Config\\BaseConfig;\n\nclass ConfigStatic extends BaseConfig\n{{\n    /**\n     * Converted settings from application/config/config.php\n     * @var array\n     */\n    public array $settings = {export_config};\n\n    /**\n     * Legacy constants defined in application/config/config.php\n     * @var array\n     */\n    public array $constants = {export_constants};\n}}\n"

out_shim = "<?php\nnamespace Config;\n\nclass Config extends ConfigStatic\n{\n    // Compatibility shim for config('Config') usage.\n}\n"

out_dir = root / 'ci4-scaffold' / 'Config'
out_dir.mkdir(parents=True, exist_ok=True)
(root / 'ci4-scaffold' / 'Config' / 'ConfigStatic.php').write_text(out_config, encoding='utf-8')
(root / 'ci4-scaffold' / 'Config' / 'Config.php').write_text(out_shim, encoding='utf-8')
print('wrote', out_dir / 'ConfigStatic.php')
print('wrote', out_dir / 'Config.php')
