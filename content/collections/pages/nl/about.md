---
id: about
blueprint: pages
site: nl
title: 'Over ons'
template: default
seo_description: 'Waarom we een platform bouwden dat websites per bezoeker laat meebewegen — en waar we in geloven.'
meta_keywords:
  - 'over ons'
  - 'mister chameleon'
  - team
  - visie
page_blocks:
- id: ctx_hero
  type: context_slot
  slot_type: hero
  variant_key: hero_default
  is_active: true
- type: text_section
  enabled: true
  variant: text_lead
  heading: 'We bouwden dit omdat de rekening ergens anders lag'
  body: '<p>B2B-marketing is de afgelopen jaren steeds preciezer geworden. Doelgroepen zijn scherp, campagnes zijn gesegmenteerd, budgetten worden per kanaal verantwoord. Alleen de website deed niet mee: één pagina, één boodschap, voor iedereen die binnenkomt.</p><p>Dat verschil kost geld op de plek waar niemand kijkt — niet in de campagne, maar in de seconden erna. Mister Chameleon is gebouwd om dat gat te dichten zonder dat u opnieuw hoeft te beginnen.</p>'
- type: feature_grid
  enabled: true
  variant: feature_grid_checklist
  heading: 'Waar we in geloven'
  items:
  - type: feature
    icon: Target
    title: 'Meten boven beloven'
    body: 'Elke personalisatie draait tegen een controlegroep. Een tool die niet kan aantonen dat hij werkt is geen tool maar een mening.'
  - type: feature
    icon: Lock
    title: 'Privacy is geen module'
    body: 'De basis werkt zonder cookies. Bewaartermijnen, verwijderverzoeken en onderdrukking zijn ingebouwd, niet bijgeschakeld.'
  - type: feature
    icon: Layers
    title: 'Uw site blijft van u'
    body: 'Geen redesign, geen platformmigratie, geen lock-in op onze frontend. Wij bewegen mee met wat u al heeft.'
  - type: feature
    icon: EyeOff
    title: 'Personalisatie mag niet opvallen'
    body: 'Als een bezoeker merkt dát er iets gebeurt, doen we het verkeerd. Server-side, zonder sprong, zonder trucje.'
- type: collection_listing
  enabled: true
  heading: 'Het team'
  intro: 'Klein gezelschap, korte lijnen. U spreekt de mensen die het bouwen.'
  collection: team_members
  variant: listing_cards
  sort_by: sort_order
  sort_direction: asc
  limit: 0
- id: ctx_cta
  type: context_slot
  slot_type: cta
  variant_key: cta_default
  is_active: true
---
