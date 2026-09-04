# Tenant page seed

Clean, valid starter pages for a **new** Statamic tenant. Every replicator item
already carries its `type`, so the CP won't choke on them. Content is **neutral
placeholder** (descriptive headings + Lorem-Ipsum body) so a fresh tenant rolls
out a presentable, brand-free site that still shows every component.

## Use it

Provisioning applies this automatically — see "Automatic seeding" below. To do
it by hand:

```bash
# From the Statamic app root, copy the seed into place:
cp -R seed/content/. content/
cp -R seed/public/.  public/
php please cache:clear && php please stache:refresh

# Populate the placeholder images referenced by the seed (Unsplash / Picsum):
bash seed/download-placeholders.sh
```

## What's included

### Pages (`content/collections/pages/nl/`)
- `home.md` — the standard context slots (hero / proof / feature / cta /
  conversion) **plus the global variant catalogue** (`hero_variants`,
  `proof_variants`, `feature_variants`, `cta_variants`, `conversion_variants`),
  filled with neutral placeholder copy. Variants are resolved globally from
  `home.md`, so any page's context slot (e.g. `variant_key: hero_default`)
  reuses these.
- `showcase.md` (`/showcase`, `noindex`) — a **components showcase**: one of
  every major block (text, text+media, feature grid, stats, logo strip,
  testimonials, video, quote, FAQ, CTA) with placeholder copy + placeholder
  images. Use it to demo how each component looks.
- `contact.md` — hero + a `form_section` wired to the `contact` form.

### Navigation, trees and globals
Seeded so the neutral site is *coherent* — a nav that only links to pages the
seed actually ships, and globals with no brand of the previous owner in them.

- `content/navigation/*.yaml` + `content/trees/navigation/nl/*.yaml` — main nav
  is Home + Contact; top bar and footer-bottom navs are empty. **Both halves
  matter:** the `navigation/` file is the nav's definition, the `trees/` file is
  its actual contents. Seeding only the first leaves the old tree in place.
- `content/trees/collections/{nl,en-gb,de}/pages.yaml` — the page structure.
  `nl` lists the three seed pages; the other locales are empty, since the seed
  ships no pages for them.
- `content/globals/nl/site_settings.yaml` — neutral name/tagline, the
  placeholder logo, no social profiles, `minimal-neutral` theme preset.
- `content/globals/nl/layout_settings.yaml` — `standard` header, `minimal`
  footer, no section tabs (triband's tabs would point at pages that no longer
  exist).
- `content/globals/nl/footer.yaml` — one column linking Home + Contact.

### Assets (`public/assets/`)
- `placeholder-logo.svg` — neutral grey "Your brand" wordmark, referenced by
  `site_settings.logo` / `logo_dark`. `public/assets` is the `assets` container
  root (see `config/filesystems.php`), so the bare filename resolves.

## Placeholder images (`download-placeholders.sh`)
The seed references neutral placeholder assets (`placeholder-wide-*.jpg`,
`placeholder-avatar-*.jpg`, `placeholder-logo-*.jpg`). The script downloads them
into the asset container at provisioning / deploy time:

- **`UNSPLASH_ACCESS_KEY` set** → fresh random Unsplash images per category.
- **no key** → Lorem Picsum (Unsplash-sourced, no key needed).

It is idempotent (skips existing files) and non-fatal (a failed download never
breaks the deploy). Wire it into the Ploi **Init container commands** so every
deploy keeps the placeholders present:

```bash
bash seed/download-placeholders.sh
```

## Add more pages (features / pricing / cases / about / team)
Copy `contact.md` as a template and swap the blocks. To reuse the personalised
slots, add `context_slot` blocks that reference keys already in the catalogue,
e.g.:

```yaml
  - id: ctx-hero
    type: context_slot
    slot_type: hero
    variant_key: hero_default   # defined in home.md's hero_variants
    is_active: true
    enabled: true
```

## Gotchas
- Keep every **replicator** item's `type` (e.g. `feature_grid.items` → `feature`,
  `timeline.items` → `item`). Grid fields (`ctas`, `members`, variant `items`)
  don't need a `type`.
- The `contact` form must exist (`resources/forms/contact.yaml`). The optional
  `appointment` form enables the "Form Section" booking request; the live
  Google-Calendar agenda is a Conversion slot with `form_key: book-demo`.

## Automatic seeding (provisioning)

The platform provisioner (`lib/provisioning/cms-provisioner.ts` in the
mister-chameleon repo) applies this seed to a **freshly generated** tenant repo
over the GitHub API, and never to a repo that already existed. It:

1. writes every file under `seed/content/**` → `content/**` and
   `seed/public/**` → `public/**`;
2. deletes every file under `content/collections/<any>/**` that the seed does
   not provide — so the template's own pages and its editorial entries (blog,
   case studies, testimonials, …) do not travel to the tenant. Collection
   *configuration* (`content/collections/<name>.yaml`) sits one level up and is
   deliberately left alone.

**So: this directory is the definition of what a new tenant starts with.** A
file added here ships to the next tenant; a collection entry not represented
here is removed from it. Nothing in the code enumerates collections by name.
