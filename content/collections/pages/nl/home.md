---
id: home
blueprint: pages
site: nl
title: Home
template: home
uri: /
updated_by: b334658b-bca1-421e-a73d-1f97e8e38070
updated_at: 1782162383
page_blocks:
  - id: ctx_hero
    type: context_slot
    slot_type: hero
    variant_key: hero_default
    is_active: true
    enabled: true
  - id: 3siDRco3FuEmNACXISLM3
    title: 'Online steunles: even goed als steunles aan huis?'
    video_source: youtube
    video_id: ksaKvMCyWRo
    video_autoplay: true
    video_loop: false
    variant: contained
    type: video
    enabled: true
  - id: ctx_proof
    type: context_slot
    slot_type: proof
    variant_key: proof_default
    is_active: true
    enabled: true
  - id: ctx_cta
    type: context_slot
    slot_type: cta
    variant_key: cta_default
    is_active: true
    enabled: true
  -
    id: AjoyKMHN
    type: feature_grid
    enabled: true
    variant: feature_grid_3up
    heading: 'Waarom kiezen voor ons'
    subtitle: 'De voordelen die het verschil maken'
    items:
      - id: OPc1icOc
        type: feature
        icon: Zap
        title: 'Snel van start'
        body: 'Live in één middag — geen lange implementaties.'
        enabled: true
      - id: SjayStK2
        type: feature
        icon: Shield
        title: Privacy-vriendelijk
        body: 'Geen cookies, geen toestemming nodig.'
        enabled: true
      - id: 0NIukOy5
        type: feature
        icon: TrendingUp
        title: 'Meetbare resultaten'
        body: 'Gemiddeld 3× hogere conversie.'
        enabled: true
      - id: eBs0suN4
        type: feature
        icon: Settings
        title: 'Eenvoudig beheer'
        body: 'Content beheren in uw vertrouwde CMS.'
        enabled: true
      - id: AwvqEy5t
        type: feature
        icon: Users
        title: 'Persoonlijke aanpak'
        body: 'Elke bezoeker krijgt de meest relevante boodschap.'
        enabled: true
      - id: mMdZ9cIU
        type: feature
        icon: BarChart2
        title: 'Inzicht & rapportage'
        body: 'Realtime inzicht in prestaties per segment.'
        enabled: true
    cta:
      variant: primary
  - id: oW783d40
    type: logo_strip
    enabled: true
    variant: default
    heading: 'Vertrouwd door toonaangevende bedrijven'
  -
    id: alEvXYHu
    type: image
    enabled: true
    variant: text_media_right
    heading: 'Gebouwd voor groei'
    body: 'Onze oplossing past zich aan elke bezoeker aan, op basis van wie ze zijn en waarom ze komen. Geen handmatige segmentatie, geen complexe regels — gewoon relevante content op het juiste moment.'
    ctas:
      - id: kIVrEIfn
        label: 'Meer over ons'
        href: /about
    alt: Afbeelding
    media_type: image
    media_bg_type: none
  -
    id: fEaylntG
    type: stats
    enabled: true
    variant: default
    items:
      - id: FCq8BYGm
        value: 250+
        label: 'tevreden klanten'
      - id: vZbzdU4G
        value: 3×
        label: 'hogere conversie'
      - id: gPyEJoXW
        value: '< 1 dag'
        label: implementatietijd
      - id: XcHcUL3m
        value: 100%
        label: GDPR-compliant
  -
    id: YyvM6XEB
    type: testimonial_section
    enabled: true
    variant: testimonial_grid
    heading: 'Wat onze klanten zeggen'
    items:
      - id: OIHgoTzD
        type: testimonial
        quote: 'Eindelijk personalisatie die écht werkt. Onze conversie is in een week verdubbeld.'
        author: 'Marie van den Berg'
        role: 'Marketing Manager'
        company: 'Voorbeeld B.V.'
        enabled: true
      - id: VDNwzh7v
        type: testimonial
        quote: 'De implementatie was verrassend eenvoudig. Binnen een dag de eerste resultaten.'
        author: 'Thomas Jansen'
        role: CTO
        company: 'Tech Startup'
        enabled: true
      - id: ZV14QXyq
        type: testimonial
        quote: 'We zien nu precies wat werkt voor welke bezoeker. Onmisbaar geworden.'
        author: 'Lisa de Vries'
        role: 'Growth Lead'
        company: Scale-up
        enabled: true
  -
    id: R0yTogZh
    type: cta_section
    enabled: true
    variant: cta_card
    heading: 'Klaar om te starten?'
    body: 'Sluit u aan bij honderden bedrijven die al personaliseren.'
    primary_cta:
      label: 'Gratis proberen'
      href: /contact
    secondary_cta:
      label: 'Demo aanvragen'
      href: /contact
hero_variants:
  -
    type: hero_variant
    key: hero_default
    is_active: true
    layout_variant: hero_default
    content_align: center
    title: 'Uw website past zich aan iedere bezoeker aan'
    subtitle: 'Mister Chameleon personaliseert uw B2B website in real-time — zonder cookies, zonder handmatig segmenteren.'
    tag: 'Website personalisatie'
    ctas:
      - label: 'Bekijk een demo'
        href: /demo
      - label: 'Hoe het werkt'
        href: /features
  -
    type: hero_variant
    key: hero_google_problem
    is_active: true
    layout_variant: hero_background
    content_align: center
    title: 'Eén regel code. Server-side. Geen geflikker.'
    subtitle: 'De keuze valt op de server, binnen 700 milliseconden, met een veilige terugval. Gaat er iets mis, dan ziet de bezoeker gewoon je normale pagina. We bewaren geen persoonsgegevens en je data staat in Europa.'
    tag: 'Voor techniek'
    ctas:
      - label: 'Praat met ons'
        href: /contact
      - label: 'Hoe het werkt'
        href: /features
  -
    type: hero_variant
    key: hero_linkedin_vision
    is_active: true
    layout_variant: hero_split
    content_align: left
    title: 'Elke klantsite een versie per bezoeker. Zonder losse landingspagina''s.'
    subtitle: 'Eén laag over de sites die je al beheert. Je richt het één keer in en stuurt maandelijks bij. Nieuw werk in de retainer, zonder dat je elke maand pagina''s bouwt.'
    tag: 'Voor bureaus'
    ctas:
      - label: 'Ontdek het platform'
        href: /features
      - label: 'Ontdek de cases'
        href: /cases
  -
    type: hero_variant
    key: hero_direct_brand
    is_active: true
    layout_variant: hero_default
    content_align: center
    title: 'Eén website. Elke bezoeker.'
    subtitle: 'Je site houdt zijn belofte. Alleen de ingang past zich aan wie er leest. Zelfde boodschap, andere insteek.'
    tag: 'Welkom bij Mister Chameleon'
    ctas:
      - label: 'Bekijk hoe het werkt'
        href: /features
      - label: 'Bekijk demo'
        href: /demo
  -
    type: hero_variant
    key: hero_consideration
    is_active: true
    layout_variant: hero_background
    content_align: center
    title: 'Je advertenties zijn scherp. Je landingspagina niet.'
    subtitle: 'Je richt precies op wie je wilt bereiken. Toch krijgt iedereen dezelfde pagina in dezelfde volgorde. Wij laten de landing aansluiten op de advertentie. En je meet zelf of het werkt.'
    tag: 'Voor marketeers'
    ctas:
      - label: 'Plan een demo'
        href: /demo
      - label: 'Bekijk cases'
        href: /cases
  -
    type: hero_variant
    key: hero_page_banner_awareness
    is_active: true
    layout_variant: hero_page_banner
    content_align: left
    title: 'Ontdek wat website personalisatie voor u kan doen'
    subtitle: 'Mister Chameleon past uw B2B website automatisch aan op iedere bezoeker — zonder cookies, zonder code.'
    tag: 'Website personalisatie'
    ctas:
      - label: 'Bekijk een demo'
        href: /demo
  -
    type: hero_variant
    key: hero_page_banner_consideration
    is_active: true
    layout_variant: hero_page_banner
    content_align: left
    title: 'Bekijk hoe Mister Chameleon bij uw aanpak past'
    subtitle: 'Vergelijk functies, lees cases en ontdek welk pakket het beste aansluit op uw groeidoelstellingen.'
    tag: 'In de overwegingsfase?'
    ctas:
      - label: 'Vergelijk opties'
        href: /pricing
      - label: 'Lees cases'
        href: /cases
  -
    type: hero_variant
    key: hero_page_banner_high_intent
    is_active: true
    layout_variant: hero_page_banner
    content_align: left
    title: 'Klaar om te starten? We zetten u direct live'
    subtitle: 'Plan een demo en ga binnen 48 uur live met gepersonaliseerde content voor uw bezoekers.'
    tag: 'Aan de slag'
    ctas:
      - label: 'Plan een demo'
        href: /demo
  -
    type: hero_variant
    key: hero_page_banner_enterprise
    is_active: true
    layout_variant: hero_page_banner
    content_align: left
    title: 'Enterprise-grade personalisatie voor uw B2B-team'
    subtitle: 'Dedicated onboarding, SLA-garantie en enterprise-integraties — voor teams die serieus personaliseren.'
    tag: Enterprise
    ctas:
      - label: 'Neem contact op'
        href: /contact
  -
    type: hero_variant
    key: hero_page_banner_returning
    is_active: true
    layout_variant: hero_page_banner
    content_align: left
    title: 'Welkom terug — we hebben het bijgehouden'
    subtitle: 'Ontdek de nieuwste functies en verbeteringen die klaarstaan voor u in uw account.'
    tag: 'Welkom terug'
    ctas:
      - label: 'Open dashboard'
        href: /dashboard
  -
    type: hero_variant
    key: hero_page_banner_friction
    is_active: true
    layout_variant: hero_page_banner
    content_align: left
    title: 'Nog vragen? We beantwoorden ze graag'
    subtitle: 'Twijfelt u ergens over? Neem contact op of bekijk onze veelgestelde vragen — we helpen u verder.'
    tag: 'Hulp nodig?'
    ctas:
      - label: 'Stel een vraag'
        href: /contact
      - label: 'Veelgestelde vragen'
        href: /faq
  -
    type: hero_variant
    key: hero_about
    is_active: true
    layout_variant: hero_page_banner
    content_align: left
    title: 'Wij geloven in relevantie voor iedere bezoeker'
    subtitle: 'Mister Chameleon werd geboren vanuit één overtuiging: iedere B2B-bezoeker verdient een website die aansluit op zijn situatie, uitdaging en fase.'
    tag: 'Over Mister Chameleon'
    ctas:
      - label: 'Bekijk een demo'
        href: /demo
  -
    type: hero_variant
    key: hero_intent_direct
    is_active: true
    layout_variant: hero_default
    content_align: center
    title: 'Klaar om te starten? Wij zetten je direct live.'
    subtitle: 'Je weet wat je wilt. Plan een demo en ga snel live met content die zich per bezoeker aanpast.'
    tag: 'Aan de slag'
    ctas:
      - label: 'Plan een demo'
        href: /demo
      - label: 'Bekijk hoe het werkt'
        href: /features
  -
    type: hero_variant
    key: hero_customer_onboarding
    is_active: true
    layout_variant: hero_default
    content_align: center
    title: 'Welkom. Je adaptieve site staat klaar.'
    subtitle: 'Koppel je domein, zet je eerste regels en je gepersonaliseerde homepage gaat live. Zonder ontwikkeltraject.'
    tag: 'Welkom'
    ctas:
      - label: 'Open de snelstart'
        href: /docs
      - label: 'Bekijk een demo'
        href: /demo
  -
    type: hero_variant
    key: hero_careers_default
    is_active: true
    layout_variant: hero_default
    content_align: center
    title: 'Kom werken bij Mister Chameleon'
    subtitle: 'We bouwen aan slimmere websites voor B2B. Zin om daaraan mee te bouwen? Bekijk waar we mensen voor zoeken.'
    tag: 'Werken bij'
    ctas:
      - label: 'Bekijk vacatures'
        href: /vacatures
      - label: 'Lees over ons'
        href: /over-ons
  -
    type: hero_variant
    key: hero_careers_job_match
    is_active: true
    layout_variant: hero_split
    content_align: left
    title: 'Vacatures die bij je passen'
    subtitle: 'Van ontwikkeling tot strategie. Vind de rol die aansluit op wat je kunt en waar je energie van krijgt.'
    tag: 'Werken bij'
    ctas:
      - label: 'Bekijk open rollen'
        href: /vacatures
      - label: 'Ontmoet het team'
        href: /team
  -
    type: hero_variant
    key: hero_careers_high_intent
    is_active: true
    layout_variant: hero_default
    content_align: center
    title: 'Klaar om te solliciteren?'
    subtitle: 'Mooi. We maken het kort en persoonlijk. Stuur je sollicitatie en we reageren snel.'
    tag: 'Werken bij'
    ctas:
      - label: 'Solliciteer nu'
        href: /solliciteren
      - label: 'Bekijk vacatures'
        href: /vacatures
  -
    type: hero_variant
    key: hero_careers_reassurance
    is_active: true
    layout_variant: hero_page_banner
    content_align: left
    title: 'Twijfel je nog? We denken graag mee.'
    subtitle: 'Niet zeker of een rol bij je past? Stel je vraag of drink een kop koffie met het team. Geen verplichtingen.'
    tag: 'Werken bij'
    ctas:
      - label: 'Stel een vraag'
        href: /contact
      - label: 'Veelgestelde vragen'
        href: /faq
proof_variants:
  -
    type: proof_variant
    key: proof_default
    is_active: true
    title: 'Meer dan 200 B2B-bedrijven groeien met Mister Chameleon'
    items:
      - title: '34% meer leads'
        text: 'Gemiddeld resultaat na 90 dagen personalisatie, gemeten over 200+ actieve B2B-klanten in Nederland en België.'
      - title: '3× hogere engagement'
        text: 'Bezoekers die relevante content zien, klikken vaker, scrollen dieper en nemen eerder contact op.'
      - title: 'No-code implementatie'
        text: 'Eén snippet in uw CMS en u bent live — geen developer nodig, geen IT-traject, geen cookiemelding.'
  -
    type: proof_variant
    key: proof_stats
    is_active: true
    title: '+34% leads, –28% bounce, 3× hogere engagement'
    items:
      - title: '+34% meer leads'
        text: 'Meer relevante bezoekers converteren naar lead omdat ze direct de boodschap zien die bij hen past.'
      - title: '–28% lager bounce'
        text: 'Minder bezoekers verlaten de pagina meteen: de eerste indruk klopt met hun verwachting.'
      - title: '3× hogere engagement'
        text: 'Klikken, scrollen, formulieren invullen — relevantie drijft elke interactie omhoog.'
  -
    type: proof_variant
    key: proof_about_origin
    is_active: true
    title: 'Vertrouwd door B2B-bedrijven in de Benelux'
    items:
      - title: 'Opgericht in 2023'
        text: 'Gestart met één overtuiging: B2B-websites moeten persoonlijker en relevanter worden voor iedere bezoeker.'
      - title: '200+ actieve klanten'
        text: 'Van scale-ups tot gevestigde namen — steeds meer B2B-teams kiezen voor Mister Chameleon om hun website te personaliseren.'
      - title: 'Live in één middag'
        text: 'Onze klanten zijn gemiddeld live binnen één middag, zonder developer en zonder IT-traject.'
  -
    type: proof_variant
    key: proof_platform
    is_active: true
    title: 'Gebouwd op een schaalbaar, privacy-first platform'
    items:
      - title: 'Server-side beslissingen'
        text: 'Elke bezoeker krijgt binnen milliseconden de juiste versie, server-side bepaald, zonder geflikker.'
      - title: 'Je data in Europa'
        text: 'Alles draait in de EER. We bewaren geen persoonsgegevens en er is altijd een veilige terugval.'
      - title: 'Eén regel code'
        text: 'Eén snippet in je site en je bent live. Geen zware integratie, geen IT-traject.'
  -
    type: proof_variant
    key: proof_cases
    is_active: true
    title: 'Zo pakt het uit bij B2B-teams zoals dat van jou'
    items:
      - title: 'Relevante landing per bron'
        text: 'Bezoekers uit een campagne zien de boodschap die bij die campagne hoort, niet een generieke homepage.'
      - title: 'Meer aanvragen'
        text: 'Teams zien meer demo-aanvragen zodra de eerste indruk klopt met de verwachting van de bezoeker.'
      - title: 'Zonder losse pagina''s'
        text: 'Geen wildgroei aan landingspagina''s meer. Eén site die zich per bezoeker gedraagt.'
  -
    type: proof_variant
    key: proof_vision
    is_active: true
    title: 'Waar B2B-websites naartoe gaan'
    items:
      - title: 'Van statisch naar contextueel'
        text: 'Een site die zich aanpast aan wie er leest, is de logische volgende stap na jaren van dezelfde pagina voor iedereen.'
      - title: 'Relevantie als standaard'
        text: 'Professionals verwachten dat wat ze zien aansluit op hun situatie. Dat wordt de norm, geen extraatje.'
      - title: 'Meetbaar en bij te sturen'
        text: 'Je ziet welke boodschap werkt en stuurt bij op data, in plaats van te gokken.'
  -
    type: proof_variant
    key: proof_reassurance
    is_active: true
    title: 'Rustig te starten, zonder risico'
    items:
      - title: 'Veilige terugval'
        text: 'Werkt er iets niet, dan ziet de bezoeker gewoon je normale pagina. Nooit een kapotte site.'
      - title: 'Privacy op orde'
        text: 'Je data staat in Europa en we bewaren geen persoonsgegevens. Meestuurbare verwerkersovereenkomst.'
      - title: 'Klein beginnen'
        text: 'Begin met één regel en breid uit zodra je ziet dat het werkt. Geen groot traject vooraf.'
  -
    type: proof_variant
    key: proof_careers_default
    is_active: true
    title: 'Waarom werken bij ons'
    items:
      - title: 'Echt impactvol werk'
        text: 'Wat je bouwt, staat live bij klanten. Je ziet direct wat je bijdrage oplevert.'
      - title: 'Ruimte om te groeien'
        text: 'Je krijgt verantwoordelijkheid en de vrijheid om je eigen vak verder te ontwikkelen.'
      - title: 'Klein en wendbaar team'
        text: 'Korte lijnen, snelle beslissingen en collega''s die elkaar helpen.'
  -
    type: proof_variant
    key: proof_careers_team
    is_active: true
    title: 'Dit is het team waar je bij komt'
    items:
      - title: 'Mensen die het snappen'
        text: 'Ontwikkelaars, strategen en makers die trots zijn op wat ze bouwen.'
      - title: 'Leren van elkaar'
        text: 'We delen kennis, geven eerlijke feedback en vieren wat lukt.'
      - title: 'Werk op jouw manier'
        text: 'Flexibele uren en plek. We sturen op resultaat, niet op aanwezigheid.'
  -
    type: proof_variant
    key: proof_careers_reassurance
    is_active: true
    title: 'Solliciteren hoeft niet spannend te zijn'
    items:
      - title: 'Kort en persoonlijk'
        text: 'Geen eindeloze rondes. Een paar goede gesprekken en je weet waar je aan toe bent.'
      - title: 'Snel duidelijkheid'
        text: 'We reageren vlot en houden je op de hoogte, ook als het een nee is.'
      - title: 'Eerst kennismaken mag'
        text: 'Nog niet zeker? Drink eerst vrijblijvend een koffie met het team.'
cta_variants:
  - type: cta_variant
    key: cta_default
    is_active: true
    title: 'Ontdek wat personalisatie voor u kan doen'
    text: 'Vraag een gratis demo aan en bekijk samen hoe uw website relevanter wordt voor iedere bezoeker.'
    cta_label: 'Demo aanvragen'
    cta_href: /demo
  - type: cta_variant
    key: cta_demo
    is_active: true
    title: 'Zie hoe het er voor je campagnes uitziet'
    text: 'In 30 minuten laten we een adaptieve landing zien rond je belangrijkste doelgroepen. Vrijblijvend.'
    cta_label: 'Plan een demo'
    cta_href: /demo
  - type: cta_variant
    key: cta_meeting
    is_active: true
    title: 'Even sparren over de techniek?'
    text: 'Plan een kennismaking van 20 minuten. We laten live zien hoe het werkt, met je eigen site als voorbeeld.'
    cta_label: 'Praat met ons'
    cta_href: /contact
  - type: cta_variant
    key: cta_guide
    is_active: true
    title: 'Klaar om je homepage relevant te maken?'
    text: 'Inrichten kost een middag. Plan een gesprek en we laten zien hoe het voor je site werkt.'
    cta_label: 'Bekijk hoe het werkt'
    cta_href: /contact
  - type: cta_variant
    key: cta_platform
    is_active: true
    title: 'Bekijk het platform in actie'
    text: 'Zie de decision-engine, de regels en de varianteditor live werken op je eigen content.'
    cta_label: 'Ontdek het platform'
    cta_href: /features
  - type: cta_variant
    key: cta_onboarding
    is_active: true
    title: 'Zet je eerste adaptieve pagina live'
    text: 'Koppel je domein en zet je eerste regels. Je gepersonaliseerde homepage staat vandaag nog live.'
    cta_label: 'Aan de slag'
    cta_href: /contact
  - type: cta_variant
    key: cta_expansion
    is_active: true
    title: 'Haal meer uit je adaptieve site'
    text: 'Breid uit met extra regels, doelgroepen en varianten zodra je ziet wat werkt.'
    cta_label: 'Bekijk de mogelijkheden'
    cta_href: /features
  - type: cta_variant
    key: cta_careers_browse
    is_active: true
    title: 'Bekijk onze vacatures'
    text: 'Zin om mee te bouwen aan slimmere B2B-websites? Kijk waar we mensen voor zoeken.'
    cta_label: 'Bekijk vacatures'
    cta_href: /vacatures
  - type: cta_variant
    key: cta_careers_apply
    is_active: true
    title: 'Klaar om te solliciteren?'
    text: 'Stuur je sollicitatie. Kort en persoonlijk, en we reageren snel.'
    cta_label: 'Solliciteer nu'
    cta_href: /solliciteren
  - type: cta_variant
    key: cta_careers_open
    is_active: true
    title: 'Bekijk de open rollen'
    text: 'Van ontwikkeling tot strategie. Vind de rol die bij je past.'
    cta_label: 'Bekijk open rollen'
    cta_href: /vacatures
  - type: cta_variant
    key: cta_careers_contact
    is_active: true
    title: 'Liever eerst even sparren?'
    text: 'Stel je vraag of drink vrijblijvend een koffie met het team.'
    cta_label: 'Neem contact op'
    cta_href: /contact
  - type: cta_variant
    key: cta_about
    is_active: true
    title: 'Wil je zien hoe Mister Chameleon werkt?'
    text: 'Bekijk in 30 minuten live hoe uw website relevant wordt voor iedere bezoeker — met uw eigen site als voorbeeld.'
    cta_label: 'Plan een demo'
    cta_href: /demo
feature_variants:
  -
    type: feature_variant
    key: feature_default
    is_active: true
    layout_variant: feature_grid
    title: 'Alles wat u nodig heeft voor slimme personalisatie'
    subtitle: 'Van real-time segmentering tot content management — alle functies die B2B-groei ondersteunen, in één platform.'
    items:
      - title: 'Real-time segmentering'
        body: 'Classificeer iedere bezoeker direct op basis van kanaal, gedrag en apparaat — zonder cookiemuur of log-in.'
      - title: 'Visuele variant-editor'
        body: 'Stel hero, proof en CTA-varianten in via een no-code editor. Publiceer en test zonder uw developer lastig te vallen.'
      - title: 'Webhooks & API'
        body: 'Koppel Mister Chameleon aan uw CRM, MAP of datalayer. Data stroomt automatisch van en naar uw bestaande tools.'
  -
    type: feature_variant
    key: feature_highlights
    is_active: true
    layout_variant: feature_highlights
    title: 'De functies die het verschil maken'
    subtitle: 'Selectief en krachtig: de kerncapaciteiten van Mister Chameleon op een rij.'
    items:
      - title: 'Regelgebaseerde personalisatie'
        body: 'Definieer zelf wanneer welke variant getoond wordt. Van simpele kanaalregels tot complexe gedragscondities — allemaal zonder code.'
      - title: A/B-testinfrastructuur
        body: 'Test twee varianten tegelijk op een gecontroleerde steekproef. Bekijk statistisch significante resultaten direct in uw dashboard.'
      - title: Prestatie-inzichten
        body: 'Zie per variant hoeveel bezoekers er doorheen gingen, hoeveel er converteerden en welke combinatie het best presteert.'
  -
    type: feature_variant
    key: feature_about_mission
    is_active: true
    layout_variant: feature_grid
    title: 'Onze missie: elke bezoeker de juiste boodschap'
    subtitle: 'We bouwen tools waarmee B2B-marketeers de controle terugkrijgen over hun website — zonder afhankelijk te zijn van developers of data-analisten.'
    items:
      - title: 'Gebouwd voor marketeers'
        body: 'Geen code, geen datateam nodig. Marketingteams beheren hun eigen personalisatieregels via een no-code interface.'
      - title: 'Privacy-first aanpak'
        body: 'Mister Chameleon werkt zonder cookies en voldoet standaard aan GDPR — geen consent banner, geen juridisch gedoe.'
      - title: 'Altijd in controle'
        body: 'U bepaalt wanneer welke boodschap getoond wordt. Van eenvoudige kanaalregels tot geavanceerde segmentlogica.'
conversion_variants:
  -
    type: conversion_variant
    key: conversion_default
    is_active: true
    layout_variant: default
    title: 'Start vandaag met bouwen'
    text: 'Maak uw account aan en verken het platform — helemaal gratis, geen creditcard vereist.'
    ctas:
      - label: 'Account aanmaken'
        href: /signup
      - label: 'Plan een demo'
        href: /demo
  -
    type: conversion_variant
    key: conversion_demo
    is_active: true
    layout_variant: demo
    title: 'Plan een persoonlijke demo'
    text: 'Onze experts laten u live zien hoe Mister Chameleon werkt met uw eigen website als uitgangspunt.'
    ctas:
      - label: 'Demo plannen'
        href: /demo
    form_key: book-demo
  -
    type: conversion_variant
    key: conversion_signup
    is_active: true
    layout_variant: signup
    title: 'Start vandaag met bouwen'
    text: 'Maak uw account aan en verken het platform — helemaal gratis, geen creditcard nodig.'
    ctas:
      - label: 'Account aanmaken'
        href: /signup
robots_noindex: false
robots_nofollow: false
---
