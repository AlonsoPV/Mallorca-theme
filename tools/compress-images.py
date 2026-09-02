from pathlib import Path
from PIL import Image

root = Path(__file__).resolve().parents[1]
demo = root / "assets" / "images" / "demo"

dup = demo / "screenshot.png"
if dup.exists():
    dup.unlink()
    print("removed demo/screenshot.png")

limits = {
    "hero.jpg": 1600,
    "story-oven.jpg": 1400,
    "experience-mesa.jpg": 1400,
    "experience-cafe.jpg": 1400,
    "experience-bolleria.jpg": 1200,
    "location-interior.jpg": 1400,
}


def compress(path: Path, max_side: int, quality: int = 72) -> None:
    img = Image.open(path)
    img = img.convert("RGB")
    width, height = img.size
    scale = min(1.0, max_side / max(width, height))
    if scale < 1:
        img = img.resize((int(width * scale), int(height * scale)), Image.Resampling.LANCZOS)
    tmp = path.with_suffix(".tmp.jpg")
    img.save(tmp, "JPEG", quality=quality, optimize=True, progressive=True)
    tmp.replace(path)
    print(f"{path.name:28} {width}x{height} -> {img.size[0]}x{img.size[1]}  {path.stat().st_size / 1024:.0f} KB")


for image_path in sorted(demo.glob("*.jpg")):
    compress(image_path, limits.get(image_path.name, 1000), 72)

src = root / "screenshot.png"
if src.exists():
    shot = Image.open(src).convert("RGB")
    shot = shot.resize((1200, 900), Image.Resampling.LANCZOS)
    out = root / "screenshot.jpg"
    shot.save(out, "JPEG", quality=74, optimize=True, progressive=True)
    src.unlink()
    print(f"screenshot.jpg {out.stat().st_size / 1024:.0f} KB")

total = sum(path.stat().st_size for path in root.rglob("*") if path.is_file() and ".git" not in path.parts)
print(f"TOTAL {total / 1024 / 1024:.2f} MB")
