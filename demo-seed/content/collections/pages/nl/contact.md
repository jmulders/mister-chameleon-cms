---
id: demo-contact
blueprint: pages
site: nl
title: Contact
template: marketing_page
uri: /contact
seo_description: 'Neem contact op met Acme. We reageren binnen één werkdag.'
page_blocks:
  - id: demo-contact-intro
    type: text_section
    enabled: true
    heading: 'Neem contact op'
    body: 'Laat weten waar je aan denkt. Een gesprek van een half uur is vaak genoeg om te weten of het klikt.'
  - id: demo-contact-form
    type: form_section
    enabled: true
    variant: form_split
    heading: 'Stuur ons een bericht'
    subtitle: 'Vul je gegevens in, dan reageren we binnen één werkdag.'
    form:
      - contact
    submit_label: Versturen
    post_submit: redirect
    redirect_target: /bedankt
  - id: demo-contact-details
    type: contact_section
    enabled: true
    variant: contact_default
    heading: 'Of bel ons gewoon'
    description: 'Op werkdagen tussen negen en vijf zit er altijd iemand aan de telefoon.'
    address: 'Voorbeeldstraat 1, 1234 AB Voorbeeldstad'
    phone: '010 123 45 67'
    email: hallo@example.com
    hours: 'Ma t/m vr, 09:00 – 17:00'
  - id: demo-contact-floating
    type: floating_contact
    enabled: true
    phone: '010 123 45 67'
    email: hallo@example.com
    side: right
robots_noindex: false
robots_nofollow: false
---
