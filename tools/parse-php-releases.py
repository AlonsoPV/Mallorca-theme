import json
from pathlib import Path

p = Path.home() / "AppData/Local/Temp/php-releases.json"
d = json.loads(p.read_text(encoding="utf-8"))
print("versions", list(d.keys()))
for v in ("8.4", "8.3", "8.2"):
    if v not in d:
        continue
    print("==", v, "==")
    for k, val in d[v].items():
        if isinstance(val, dict) and "zip" in val:
            print(k, val["zip"].get("path"))
