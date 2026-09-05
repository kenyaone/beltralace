#!/usr/bin/env bash
# beltralace prod reset — restore live site to match `origin/main`.
# Safe to re-run. Takes a snapshot before touching anything.
#
# Usage (in cPanel Terminal):
#   bash beltralace-prod-reset.sh
#
# Override site dir if needed:
#   SITE_DIR=~/beltralace.com bash beltralace-prod-reset.sh

set -euo pipefail

SITE_DIR="${SITE_DIR:-$HOME/public_html}"
REPO_URL="https://github.com/kenyaone/beltralace"
TARGET_REF="${TARGET_REF:-origin/main}"
STAMP="$(date +%Y%m%d-%H%M%S)"

echo "=== beltralace prod reset ==="
echo "Site dir:   $SITE_DIR"
echo "Target ref: $TARGET_REF"
echo "Timestamp:  $STAMP"
echo ""

[ -d "$SITE_DIR" ] || { echo "ERROR: $SITE_DIR does not exist. Set SITE_DIR=... and rerun."; exit 1; }

read -r -p "Type YES to proceed (anything else aborts): " CONFIRM
[ "$CONFIRM" = "YES" ] || { echo "Aborted."; exit 1; }

if [ -d "$SITE_DIR/.git" ]; then
    IS_GIT=1
    echo "Detected: git repository."
else
    IS_GIT=0
    echo "Detected: NOT a git repository (files-only)."
fi

# --- Phase 0: snapshot -------------------------------------------------------
SNAP="$HOME/beltralace-prod-snapshot-$STAMP"
echo ""
echo "[1/4] Snapshotting current prod to $SNAP ..."
cp -a "$SITE_DIR" "$SNAP"
echo "      done. Manual rollback if needed:"
echo "        rm -rf \"$SITE_DIR\" && mv \"$SNAP\" \"$SITE_DIR\""
echo ""

if [ "$IS_GIT" = "1" ]; then
    # --- Case A: in-place reset ---------------------------------------------
    cd "$SITE_DIR"

    echo "[2/4] Stashing any uncommitted server edits (safety net)..."
    if ! git diff --quiet || ! git diff --cached --quiet || [ -n "$(git ls-files --others --exclude-standard)" ]; then
        git stash push -u -m "prod-state-before-reset-$STAMP" || true
        echo "      stashed. Recover later with: git stash list ; git stash apply"
    else
        echo "      nothing to stash."
    fi
    echo ""

    echo "[3/4] Fetching from origin and hard-resetting to $TARGET_REF ..."
    git fetch origin
    git reset --hard "$TARGET_REF"
    echo ""

    echo "[4/4] Cleaning untracked junk (ignored files preserved by .gitignore)..."
    git clean -fd
else
    # --- Case B: clone-and-swap ---------------------------------------------
    NEW="$HOME/beltralace-new-$STAMP"

    echo "[2/4] Cloning fresh copy to $NEW ..."
    git clone "$REPO_URL" "$NEW"
    cd "$NEW"
    git checkout "${TARGET_REF#origin/}"
    echo ""

    echo "[3/4] Copying server-only files (env, htaccess, uploads, vendor)..."
    for f in \
        .env \
        .htaccess \
        admin/.htaccess \
        admin/config/env/.config.json \
        admin/config/env/.database.json \
        admin/config/env/client_secret.json \
        frontend/config/env/.config.json \
        api/config/env/.config.json \
        api/config/env/.database.json \
        config/.credentials.txt ; do
        if [ -f "$SITE_DIR/$f" ]; then
            mkdir -p "$(dirname "$NEW/$f")"
            cp -a "$SITE_DIR/$f" "$NEW/$f"
            echo "      copied: $f"
        fi
    done
    for d in uploads vendor; do
        if [ -d "$SITE_DIR/$d" ]; then
            cp -a "$SITE_DIR/$d" "$NEW/"
            echo "      copied: $d/"
        fi
    done
    echo ""

    echo "[4/4] Swapping in the new tree (near-instant)..."
    mv "$SITE_DIR" "${SITE_DIR}.old-$STAMP"
    mv "$NEW" "$SITE_DIR"
    echo "      old tree preserved at: ${SITE_DIR}.old-$STAMP"
fi

# --- Final report ------------------------------------------------------------
echo ""
echo "=== Done ==="
cd "$SITE_DIR"
echo "HEAD is now: $(git log -1 --oneline)"
echo ""
echo "Verify manually:"
echo "  1. Load https://beltralace.com in a browser (hard refresh: Ctrl+Shift+R)."
echo "  2. Try the contact form and one admin login."
echo "  3. Check any page that recently had edits."
echo ""
echo "Roll back if broken:"
if [ "$IS_GIT" = "1" ]; then
    echo "  rm -rf \"$SITE_DIR\" && mv \"$SNAP\" \"$SITE_DIR\""
    echo "  (stashed edits, if any, are inside the snapshot's .git/)"
else
    echo "  rm -rf \"$SITE_DIR\" && mv \"${SITE_DIR}.old-$STAMP\" \"$SITE_DIR\""
fi
