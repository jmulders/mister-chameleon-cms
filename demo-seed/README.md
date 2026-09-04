# Demo site seed

A curated, **brand-free** Dutch example site for a new Statamic tenant. Where
`seed/` gives a blank canvas, this gives a site that is presentable the moment
it rolls out: every block type filled in, real collection entries, working
navigation and an adaptive hero.

The example brand is **Acme** throughout — a placeholder, not a real company.
To rename it, search this directory for `Acme` (and `demo-logo*.svg` in
`public/assets/`); nothing else refers to it.

## How it is applied

The platform provisioner (`lib/provisioning/cms-provisioner.ts` in the
mister-chameleon repo) applies this to a **freshly generated** tenant repo when
the rollout mode is *Demo*, through exactly the same mechanism as `seed/`:

1. every file under `demo-seed/content/**` → `content/**` and
   `demo-seed/public/**` → `public/**`;
2. every collection entry the seed does not provide is deleted, so the
   template's own content does not travel to the tenant.

**So this directory is the definition of what a demo tenant starts with.** No
code enumerates pages or collections by name.

To apply it by hand:

```bash
cp -R demo-seed/content/. content/
cp -R demo-seed/public/.  public/
php please cache:clear && php please stache:refresh
bash seed/download-placeholders.sh   # the placeholder images this seed references
```

## What's in it

**Pages** (`content/collections/pages/nl/`)

| Page | Shows |
| --- | --- |
| `home` | adaptive hero slot, feature grid, stats, logo strip, testimonials, FAQ, CTA, form (message), text+media |
| `diensten` | feature grid, process steps, rich text, CTA |
| `prijzen` | feature grid (the three plans), FAQ, CTA |
| `cases` | collection listing (case studies), media slider, related content, CTA |
| `over-ons` | team section, video, quote, timeline, stats, testimonials |
| `contact` | form (redirect → `/bedankt`), contact details, floating contact |
| `bedankt` | the redirect target |

Between them, **every block type** declared in `mc_page_blocks.yaml` appears at
least once — that is the point of the demo, and there is a check for it in the
PR that added this.

**Collections** — 3 case studies, 3 testimonials, 4 features, 3 pricing plans,
3 team members, 4 FAQ items, 2 blog posts. All generic.

**Navigation** — Home, Diensten, Prijzen, Cases, Over ons, Contact. Both halves:
the definition in `content/navigation/` and the tree in
`content/trees/navigation/nl/`. Seeding only the first leaves the old tree in
place.

**Globals** — `site_settings` (Acme, light + dark logo for the theme switch),
`layout_settings` (triband header with one neutral section tab), `footer` (two
neutral columns).

## The adaptive hero

`home.md` ships two hero variants in its catalogue, `hero_default` and
`hero_enterprise`, and its first block is a `context_slot` pointing at the hero.

Both keys are deliberately from the platform's `ALLOWED_HERO_KEYS`. A Statamic
tenant has no `extraKeys`, so a rule naming a CMS-invented key would be rejected
by `validateStoredConfig` and the slot would never switch. The
CMS side is only half of it: the platform seeds an adaptive block and a rule for
the tenant so the slot actually switches. Without that platform data the slot
renders `hero_default` and nothing more.

## Gotchas

- Keep every **replicator** item's `type` (`feature_grid.items` → `feature`,
  `process_steps.steps` → `step`, `timeline.items` → `item`,
  `listing.media_items` → `slide`). Grid fields (`ctas`, `members`, `logos`)
  don't need one.
- Field values are checked against the blueprints, not guessed. `select` values
  must exist in that field's options and global keys must be real handles — a
  wrong value silently drops in the CP.
- `collection_listing` can only target `blog`, `vacancies`, `case_studies` or
  `team_members`. The pricing page therefore renders its plans as a feature
  grid; the `pricing_plans` entries ship anyway, for the CP to show.
- The `contact` form must exist (`resources/forms/contact.yaml`).
- Placeholder images come from `seed/download-placeholders.sh`, which both seeds
  share.
