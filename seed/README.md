# Tenant page seed

Clean, valid starter pages for a **new** Statamic tenant. Every replicator item
already carries its `type`, so the CP won't choke on them.

## Use it

```bash
# From the Statamic app root, copy the seed pages into content:
cp -R seed/content/. content/
php please cache:clear && php please stache:refresh
```

## What's included
- `home.md` — the standard context slots (hero / proof / feature / cta /
  conversion) **plus the global variant catalogue** (`hero_variants`,
  `proof_variants`, `feature_variants`, `cta_variants`, `conversion_variants`).
  Variants are resolved globally from `home.md`, so any page's context slot
  (e.g. `variant_key: hero_default`) reuses these.
- `contact.md` — hero + a `form_section` wired to the `contact` form.

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
