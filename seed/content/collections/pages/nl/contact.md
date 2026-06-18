---
id: contact
blueprint: pages
site: nl
title: Contact
template: marketing_page
uri: /contact
seo_description: 'Get in touch — we reply within one business day.'
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
    heading: 'Send us a message'
    subtitle: 'We reply within one business day.'
    form:
      - contact
    enabled: true
robots_noindex: false
robots_nofollow: false
---
