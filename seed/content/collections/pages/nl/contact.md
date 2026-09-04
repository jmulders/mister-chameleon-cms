---
id: contact
blueprint: pages
site: nl
title: Contact
template: marketing_page
uri: /contact
seo_description: 'Neem contact op — vervang deze placeholder-tekst door je eigen content.'
page_blocks:
  - id: ctx-hero
    type: context_slot
    slot_type: hero
    variant_key: hero_default
    is_active: true
    enabled: true
  - id: contact-form
    type: form_section
    variant: form_inline
    heading: 'Stuur ons een bericht'
    subtitle: 'We reageren binnen één werkdag.'
    form:
      - contact
    enabled: true
robots_noindex: false
robots_nofollow: false
---
