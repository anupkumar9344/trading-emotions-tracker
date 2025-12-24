# How to Add Screenshots to README

## Step-by-Step Guide

### 1. Take Screenshots

Take screenshots of your website at different stages:

- **Dashboard** (`dashboard.png`): Main page showing today's trades
- **Pre-Trade Checklist** (`pre-trade-checklist.png`): The pre-trade form
- **In-Trade Emotions** (`in-trade-emotions.png`): In-trade tracking form
- **Post-Trade Review** (`post-trade-review.png`): Post-trade review form
- **Trade History** (`trade-history.png`): History page with completed trades
- **Language Switcher** (`language-switcher.png`): Language dropdown in action

### 2. Save Images

Save your screenshots in the `docs/images/` directory with the exact filenames mentioned above.

### 3. Image Requirements

- **Format**: PNG (recommended) or JPG
- **Size**: 1200x800px or similar (maintain aspect ratio)
- **Quality**: High quality, clear and readable text
- **File Size**: Keep under 500KB per image (optimize if needed)

### 4. Optimize Images (Optional but Recommended)

You can optimize images using tools like:

- **Online**: [TinyPNG](https://tinypng.com/), [Squoosh](https://squoosh.app/)
- **Command Line**: 
  ```bash
  # Using ImageMagick
  convert screenshot.png -quality 85 -resize 1200x800 screenshot-optimized.png
  ```

### 5. Alternative: Using GitHub Issues/Releases

If you want to host images externally:

1. Upload images to GitHub Issues (create a dummy issue, upload images, copy URLs)
2. Or use GitHub Releases
3. Or use image hosting services (Imgur, Cloudinary, etc.)

Then update the README with absolute URLs:

```markdown
![Dashboard](https://user-images.githubusercontent.com/your-image-url.png)
```

### 6. Using Relative Paths (Current Method)

The current README uses relative paths:

```markdown
![Dashboard](docs/images/dashboard.png)
```

This works when:
- Images are in the repository
- README is viewed on GitHub
- Images are committed to git

### 7. Adding Images to Git

```bash
# Add images to git
git add docs/images/*.png

# Commit
git commit -m "Add website screenshots"

# Push
git push
```

### 8. Testing

After adding images:
- Check if they appear correctly on GitHub
- Verify images load in the README preview
- Ensure file paths are correct

## Quick Reference: Markdown Image Syntax

```markdown
<!-- Basic -->
![Alt text](path/to/image.png)

<!-- With title -->
![Alt text](path/to/image.png "Image Title")

<!-- With link -->
[![Alt text](path/to/image.png)](https://link-url.com)

<!-- Resized (GitHub doesn't support, but some renderers do) -->
<img src="path/to/image.png" width="600" alt="Alt text">
```

## Example README Section

```markdown
## Screenshots

<div align="center">
  <img src="docs/images/dashboard.png" alt="Dashboard" width="800"/>
  <p><em>Main Trading Dashboard</em></p>
</div>

<div align="center">
  <img src="docs/images/pre-trade-checklist.png" alt="Pre-Trade Checklist" width="800"/>
  <p><em>Pre-Trade Checklist Form</em></p>
</div>
```

## Troubleshooting

**Images not showing?**
- Check file paths are correct
- Ensure images are committed to git
- Verify file extensions match (.png vs .PNG)
- Check file permissions

**Images too large?**
- Optimize images before committing
- Use image compression tools
- Consider using external hosting for large files

**Want to add more images?**
- Just add them to `docs/images/`
- Update README with new image references
- Follow the same naming convention

