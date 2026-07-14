---
id: features
blueprint: pages
site: nl
title: 'Wat Mister Chameleon doet'
template: default
seo_description: 'Uw website past zich per bezoeker aan — server-side, op uw bestaande site en CMS. Herkennen, aanpassen, en bewijzen dat het werkt.'
meta_keywords:
  - personalisatie
  - 'b2b website'
  - conversie
  - 'adaptive website'
  - leadherkenning
page_blocks:
  - id: ctx-hero
    type: context_slot
    slot_type: hero
    variant_key: hero_features
    is_active: true
    enabled: true
  - type: text_section
    enabled: true
    variant: text_lead
    heading: 'Uw campagne is gesegmenteerd. Uw website niet.'
    body: '<p>U investeert in positionering: een scherp ICP, proposities per segment, advertenties die precies de juiste persoon aanspreken. En dan landt die persoon op dezelfde homepage als iedereen. Mister Chameleon maakt van uw bestaande site een site die zich per bezoeker aanpast — zonder redesign, zonder migratie, zonder developmentsprint.</p>'
  - id: ctx-proof
    type: context_slot
    slot_type: proof
    variant_key: proof_features_stats
    is_active: true
    enabled: true
  - type: feature_grid
    enabled: true
    variant: feature_grid_3up
    heading: 'Wat het platform doet'
    items:
      - type: feature
        icon: Search
        title: Herkennen
        body: 'Bron, campagne, zoekwoord, gedrag en terugkeer. En zakelijk: welk bedrijf achter het IP zit, aangevuld met KvK-gegevens en wat er al in uw CRM staat.'
      - type: feature
        icon: Shuffle
        title: Aanpassen
        body: 'U wijst de blokken aan die mogen meebewegen — hero, bewijs, CTA. Per doelgroep bepaalt u de boodschap; de rest van de pagina blijft staan zoals hij staat.'
      - type: feature
        icon: FlaskConical
        title: Bewijzen
        body: 'Elke aanpassing draait tegen een controlegroep die de gewone site ziet. U meet de werkelijke lift, in plaats van te geloven dat het hielp.'
      - type: feature
        icon: Server
        title: Server-side
        body: 'De beslissing valt vóórdat de pagina bij de bezoeker aankomt. Geen flikkering, geen sprong, geen vertraging — en zoekmachines zien een gewone, snelle pagina.'
      - type: feature
        icon: ShieldCheck
        title: AVG-first
        body: 'De basis werkt zonder cookies en zonder profielopbouw. Verrijking zit achter uw eigen instellingen, en een verwijderverzoek loopt door tot in uw CRM.'
      - type: feature
        icon: Plug
        title: 'Op uw eigen CMS'
        body: 'Statamic, Sanity of Storyblok — of één snippet op een site die u houdt zoals hij is. Uw redactie blijft werken in de omgeving die ze al kent.'
  - id: ctx-feature
    type: context_slot
    slot_type: feature
    variant_key: feature_full_platform
    is_active: true
    enabled: true
  - type: text_section
    enabled: true
    variant: text_split
    heading: 'De lus loopt door tot in uw advertentiebudget'
    body: '<p>Personalisatie stopt bij de meeste tools zodra de bezoeker converteert. Hier begint het dan pas. Wie een formulier invult wordt herkend en verrijkt — bedrijf, KvK, firmografie — en als conversie teruggemeld aan Google, LinkedIn en Meta.</p><p>Het gevolg: uw campagnes optimaliseren op échte leads in plaats van op formulierinzendingen. En sales ziet in het CRM welk account op de site was, hoe vaak, en waar het naar keek. Wie zich afmeldt of om verwijdering vraagt, wordt in dezelfde beweging bij de advertentieplatforms onderdrukt.</p>'
  - type: process_steps
    enabled: true
    variant: default
    heading: 'Hoe u start'
    steps:
      - type: step
        number: '1'
        title: Koppelen
        body: 'Eén snippet, of een integratie met uw CMS. Uw site blijft van u en blijft draaien waar hij draait.'
        duration: 'een middag'
      - type: step
        number: '2'
        title: Herkennen
        body: 'We zetten de signalen aan die voor u relevant zijn — campagnebron, bedrijf, terugkerend bezoek.'
        duration: 'week 1'
      - type: step
        number: '3'
        title: Aanpassen
        body: 'U kiest de blokken die mogen meebewegen en schrijft de varianten per doelgroep. Begin met de hero; daar is het meeste te winnen.'
        duration: 'week 1–2'
      - type: step
        number: '4'
        title: Bewijzen
        body: 'De controlegroep loopt vanaf dag één mee. Na de eerste weken weet u wat het opleverde — en of het iets opleverde.'
        duration: doorlopend
  - type: faq_section
    enabled: true
    variant: faq_default
    heading: 'Wat mensen ons vragen'
    source_mode: manual
    items:
      - question: 'Moet ik mijn website opnieuw laten bouwen?'
        answer: 'Nee. Mister Chameleon draait op uw bestaande site en uw bestaande CMS. Er is geen redesign en geen migratie; de koppeling is een snippet of een CMS-integratie.'
      - question: 'Wordt mijn site er langzamer van?'
        answer: 'Nee. De beslissing valt server-side, vóórdat de pagina wordt verstuurd. Er komt geen script tussen dat eerst de standaardpagina toont en die daarna verbouwt.'
      - question: 'Heb ik hier een cookiebanner voor nodig?'
        answer: 'Voor de basis niet: die werkt zonder cookies en zonder profielopbouw. Verrijking op persoonsniveau zit achter instellingen die u zelf bepaalt.'
      - question: 'Hoe weet ik of het écht werkt?'
        answer: 'Elke aanpassing draait tegen een controlegroep die de gewone site te zien krijgt. Het verschil tussen beide groepen is uw resultaat — geen aanname, maar een meting.'
      - question: 'Werkt dit met mijn CMS?'
        answer: 'Statamic, Sanity en Storyblok worden ondersteund. Heeft u iets anders, dan werkt de snippet op elke site; uw redactie verandert er niets aan.'
      - question: 'Wat gebeurt er met de gegevens van bezoekers?'
        answer: 'Profielen kennen een bewaartermijn en worden automatisch opgeruimd. Een verwijderverzoek werkt door tot in uw CRM en onderdrukt het profiel ook bij de advertentieplatforms.'
  - id: ctx-cta
    type: context_slot
    slot_type: cta
    variant_key: cta_features_bottom
    is_active: true
    enabled: true
robots_noindex: false
robots_nofollow: false
---
