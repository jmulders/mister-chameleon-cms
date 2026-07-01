# Mister Chameleon — Adaptive Slots for Statamic (client-side edition)

Add Mister Chameleon's per-visitor personalisation to **any existing Statamic
site** — including sites that were **not** built on the Mister Chameleon platform.

You get native **page-builder blocks** ("Context Slots") that authors edit in the
Statamic Control Panel. Each block renders its CMS-authored content server-side
(SEO- and bot-safe), and the Mister Chameleon snippet swaps it per visitor in the
browser. Think "the snippet you'd drop on a WordPress site", but delivered as
first-class, editable Statamic blocks.

## What's in this bundle

```
fieldsets/mc_context_slot.yaml     The page-builder block (fields for the fallback content)
views/mc_context_slot.antlers.html Renders one slot: SSR fallback + data-mc-slot markers
views/mc_snippet.antlers.html      Loads the personalisation snippet (put in <head>)
```

## How it works

1. An author adds a **Context Slot** block to a page and picks a slot type
   (Hero, Social proof, CTA, Feature, Conversion, Notification) and writes the
   default copy.
2. On render, the block outputs that copy **server-side** with `data-mc-slot`
   markers. Bots, no-JS visitors, and any request made while the platform is
   unreachable see this default — nothing breaks, SEO is intact.
3. The snippet in `<head>` calls `POST https://app.misterchameleon.com/api/snippet/decide`
   with the visitor's context and **swaps the marked elements** with the variant
   chosen by your Mister Chameleon rules.

## Install (≈10 minutes)

### 1. Copy the files into your Statamic project

```
cp fieldsets/mc_context_slot.yaml       resources/fieldsets/
cp views/mc_context_slot.antlers.html   resources/views/partials/
cp views/mc_snippet.antlers.html        resources/views/partials/
```

### 2. Add the block to your page builder

In the Replicator/Bard field of your page blueprint, add a set that imports the
fieldset:

```yaml
sets:
  mc_context_slot:
    display: 'Adaptive slot (Mister Chameleon)'
    icon: light-bulb
    fields:
      - import: mc_context_slot
```

### 3. Render the block in your page-builder loop

Wherever you render your blocks, dispatch `context_slot` to the partial:

```antlers
{{ page_blocks }}
  {{ if type == 'context_slot' }}
    {{ partial:mc_context_slot }}
  {{ else }}
    {{# ...your existing block types... #}}
  {{ /if }}
{{ /page_blocks }}
```

### 4. Load the snippet in your layout `<head>`

```antlers
<head>
  {{# ... #}}
  {{ partial:mc_snippet }}
</head>
```

Set your **site key** (from the Mister Chameleon dashboard → Setup → Snippet).
Either define an `mc_site_key` variable (a global or `.env`-surfaced value), or
edit the fallback string in `mc_snippet.antlers.html`.

### 5. Register the site on the platform

In the Mister Chameleon dashboard, provision a **site key** for this site's
domain and configure its variants/rules. The snippet is domain-agnostic
(`CORS: *`), but the decision engine only personalises sites it knows.

## Slot contract

The `data-mc-slot` keys the partial emits match the platform's decision output:

| Slot type    | Keys emitted                                                            |
|--------------|-------------------------------------------------------------------------|
| hero         | `hero-tag`, `hero-title`, `hero-subtitle`, `hero-cta-label`, `hero-cta-href` |
| proof        | `proof-title`                                                           |
| cta          | `cta-title`, `cta-text`, `cta-cta-label`, `cta-cta-href`                |
| feature      | `feature-title`, `feature-subtitle`                                     |
| conversion   | `conversion-title`, `conversion-text`, `conversion-cta-label`, `conversion-cta-href` |
| notification | `notification-message`, `notification-cta-label`, `notification-cta-href` |

## Notes & limits

- **One slot of each type per page.** The client-side snippet swaps by slot type,
  so two hero slots on one page would receive the same content. For multiple
  distinct slots of the same type — or fully server-rendered personalisation with
  no client swap — use the **PHP-tag edition** (server-side render via a Statamic
  tag that calls `/api/snippet/decide` at request time). That edition is the
  recommended next step and removes the one-per-type limit and the brief swap.
- **Images/media are static fallbacks.** The client-side edition personalises copy
  and links, not images.
- **Rich text:** add `data-mc-html="true"` to an element if its variant value
  contains HTML you want injected as markup rather than text.
