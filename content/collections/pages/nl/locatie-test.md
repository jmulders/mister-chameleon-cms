---
id: locatie-test
blueprint: pages
site: nl
title: Locatie-test
template: default
page_blocks:
  - id: ctx_hero
    type: context_slot
    slot_type: hero
    variant_key: hero_default
    is_active: true
  - id: loc_form
    type: form_section
    enabled: true
    variant: form_inline
    heading: 'Locatie-test'
    subtitle: 'Vul postcode en huisnummer in. Na verzenden staat de mc_loc-cookie; herlaad de pagina om de CBS-, BAG- en netbeheer-verrijking te zien in de demo-readout.'
    form: locatie-test
robots_noindex: true
robots_nofollow: true
---
