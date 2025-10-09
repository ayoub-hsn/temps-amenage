document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector(".menu-toggle");
    const navLinks = document.querySelector(".nav-links");

    menuToggle.addEventListener("click", () => {
        navLinks.classList.toggle("active");
        menuToggle.classList.toggle("active");
    });

    const currentPath = window.location.pathname.split("/").pop();
    const links = document.querySelectorAll(".nav-links a");
    links.forEach(link => {
        if (link.getAttribute("href") === currentPath) {
            link.classList.add("active");
        }
    });

    const establishments = {
        'feg': {
            'img': 'images/logo-feg.png',
            'title': 'FEG',
            'description': `<p>La Faculté d'Économie et de Gestion à Settat fait partie de l'Université Hassan Premier. Fondée en 2020, cette institution accueille environ 12 000 étudiants. Son programme diversifié propose à la fois des formations fondamentales et continues, en adéquation avec les besoins du marché de l'emploi.</p>
                            <p>Implantée au sein de l'Université Hassan Premier, la Faculté d'Économie et de Gestion à Settat a vu le jour en 2020. Cette institution dynamique offre un environnement d'apprentissage stimulant à une importante communauté estudiantine composée d'environ 12 000 individus. Au cœur de son engagement, elle assure des programmes de formation complets et adaptés aux évolutions du monde professionnel.</p>
                            <p>La mission de la Faculté d'Économie et de Gestion à Settat est double : former et accompagner. En tant qu'établissement universitaire, elle s'engage à dispenser des formations de qualité, tant dans les disciplines fondamentales que dans des domaines spécialisés, afin de préparer ses étudiants à intégrer le marché du travail avec succès. Son approche pédagogique résolument tournée vers l'évolution des besoins économiques garantit une réponse pertinente aux défis contemporains.</p>`,
            'masterLink': 'http://example.com/preinscription-master-feg',
            'licenceLink': 'http://example.com/preinscription-licence-feg'
        },
        'fsjp': {
            'img': 'images/logo-fsjp.webp',
            'title': 'FSJP',
            'description': `<p>La Faculté des Sciences Juridiques et Politiques de Settat a été créée en 1997. Elle permet, chaque année, de former des juristes opérationnels. Les activités de la faculté sont organisées autour de deux missions essentielles: l’enseignement et la recherche.</p>
                            <p>Dans le cadre de sa mission d’enseignement, la Faculté assure la préparation et la Délivrance de plusieurs diplômes universitaires. Sa mission de recherche et d’encadrement tend à susciter et à favoriser la réflexion des chercheurs (enseignants, étudiants, praticiens etc…) dans différents domaines. Cette mission trouve sa concrétisation dans la rédaction de mémoires de licence, rapports de stages, mémoires de master et thèses de doctorat et dans les différentes publications de la Faculté notamment sa revue Les cahiers de droit.</p>
                            `,
            'masterLink': 'http://example.com/preinscription-master-fsjp',
            'licenceLink': 'http://example.com/preinscription-licence-fsjp'
        },
        'fst': {
            'img': 'images/logo-fst.png',
            'title': 'FST',
            'description': `<p>La Faculté des Sciences et Techniques (FST) de Settat se distingue par son approche pédagogique diversifiée, offrant un éventail de plus de 30 filières à différents niveaux de formation. Axée sur la recherche scientifique, notre institution accorde une importance primordiale au Centre des Études Doctorales (CED), véritable pivot de nos activités de recherche et contributeur essentiel à la renommée de notre établissement dans le domaine scientifique. Avec 27 équipes de recherche réparties dans neuf laboratoires agréés, nous sommes résolument engagés dans l'avancement du savoir et de la connaissance.</p>
            <p>Depuis 2003, la FST de Settat s'inscrit dans le cadre du système L.M.D (Licence, Master, Doctorat), reflétant notre vision pédagogique novatrice. Cette approche met en avant des atouts considérables tels que l'engagement pédagogique et scientifique de nos enseignants-chercheurs, notre ancrage local et régional au sein d'un bassin d'emploi dynamique, ainsi que des conditions d'études et un environnement pédagogique propices à l'épanouissement scientifique de nos étudiants. Nous nous distinguons également par notre engagement continu en faveur de la formation continue, notre ouverture sur le monde socioéconomique et la mise en place d'accords de coopération variés.</p>
            <p>Au cœur de notre mission à la FST de Settat se trouve un engagement ferme envers l'excellence académique et la recherche scientifique. Nous nous efforçons de former des individus compétents et créatifs, prêts à relever les défis du monde moderne. Notre établissement est un lieu où l'innovation, la collaboration et la découverte sont encouragées, offrant ainsi à nos étudiants les outils nécessaires pour réussir dans leurs carrières et contribuer au progrès de la société.</p>`,
            'masterLink': 'http://example.com/preinscription-master-fst',
            'licenceLink': 'http://example.com/preinscription-licence-fst'
        },
        'encg': {
            'img': 'images/logo-encg.png',
            'title': 'ENCG',
            'description': `<p>Depuis sa fondation en 1994, l'École Nationale de Commerce et de Gestion de Settat (ENCG) s'est dédiée à répondre aux exigences du marché de l'emploi dans les domaines du commerce et de la gestion. Forte d'une ingénierie pédagogique exceptionnelle et d'une recherche scientifique confirmée, elle s'est rapidement affirmée comme une institution d'excellence, bénéficiant d'un réseau de coopérations académiques et scientifiques riches et diversifiées, tant au niveau national qu'international. Grâce à une gouvernance moderne et un soutien institutionnel solide, l'ENCG Settat a consolidé sa position de leader national en tant que Business-school d'excellence en Afrique.</p>
            <p>L'ENCG Settat se distingue par la qualité de son corps professoral et administratif, ainsi que par ses étudiants sélectionnés avec rigueur. Les programmes de formation initiale et continue sont en parfaite adéquation avec les besoins des entreprises marocaines, offrant des formations professionnelles reconnues internationalement. Les laboratoires de recherche de l'école se concentrent sur des axes fédérateurs tels que le management, le marketing, l'entrepreneuriat, ou encore les systèmes d'information et d'aide à la décision, contribuant ainsi à l'avancement des connaissances dans ces domaines cruciaux.</p>
            <p>L'ENCG Settat s'engage pleinement dans l'épanouissement de ses étudiants, avec un taux d'insertion professionnelle proche de 100%. En plus de leur formation académique solide, les étudiants bénéficient d'une attention particulière pour leur développement personnel à travers des activités culturelles, sportives, entrepreneuriales et sociales. L'école entretient également des partenariats internationaux avec divers pays, offrant à ses étudiants des opportunités de mobilité et d'échanges enrichissants. Dans un souci constant d'innovation, l'ENCG Settat continue de développer des programmes et des recherches pertinentes, alignées sur les enjeux du développement durable et les besoins de la société marocaine.</p>`,
            'masterLink': 'http://example.com/preinscription-master-encg',
            'licenceLink': 'http://example.com/preinscription-licence-encg'
        },
        'i2s': {
            'img': 'images/logo-i2s.png',
            'title': 'I2S',
            'description': `<p>L'Institut des Sciences du Sport de Settat (I2S Settat) représente un pilier essentiel de l'enseignement supérieur au sein de l'Université Hassan 1er de Settat. Dédié à la formation dans le domaine des sciences du sport, il offre des programmes de licence     et de master axés sur l'éducation physique et sportive, le management du sport ainsi que le sport et la santé.</p>
            <p>Au cœur de sa mission éducative, l'I2S Settat se consacre à la préparation de ses étudiants à devenir des enseignants compétents en éducation physique et sportive. Grâce à un ensemble de cursus académiques et pratiques, l'institut vise à fournir à ses diplômés les compétences nécessaires pour intervenir efficacement dans le domaine de l'éducation physique et contribuer à la promotion d'un mode de vie sain et actif.</p>`,
            'masterLink': 'http://example.com/preinscription-master-i2s',
            'licenceLink': 'http://example.com/preinscription-licence-i2s'
        },
        'i3s': {
            'img': 'images/logo-i3s.png',
            'title': 'I3S',
            'description': `<p>Les programmes de formation universitaire en sciences infirmières, en sages-femmes, ainsi qu'en technologie paramédicale spécialisée, ont comblé un vide crucial dans le système éducatif marocain. Cette initiative visionnaire a permis aux étudiants d'accéder à des cursus de haute qualité, alignés sur les normes internationales et répondant aux besoins complexes du secteur de la santé.</p>
            <p>En tant que composante intégrale de l'université Hassan Premier de Settat, cet institut s'inscrit dans une dynamique d'innovation et d'excellence académique. En adoptant l'architecture pédagogique LMD, il a non seulement modernisé ses méthodes d'enseignement, mais a également ouvert de nouvelles perspectives pour les futurs professionnels de la santé au Maroc. Cette approche éducative flexible et adaptative reflète l'engagement continu de l'institut à former des professionnels compétents et hautement qualifiés, prêts à relever les défis complexes du secteur de la santé dans un monde en constante évolution.</p>`,
            'masterLink': 'http://example.com/preinscription-master-i3s',
            'licenceLink': 'http://example.com/preinscription-licence-i3s'
        },
        'flash': {
            'img': 'images/Logo-FLASH.jpg',
            'title': 'FLASH',
            'description': `<p>La Faculté des Langues, Arts et Sciences Humaines de Settat évolue sous la tutelle de l’Université Hassan I (UH1). Elle a pour ambition de répondre aux défis posés par le monde d’aujourd’hui. Elle se donne pour objectif d’offrir à ses étudiants un milieu d’apprentissage agréable et serein.</p>
            <p>Ainsi, pour mieux appréhender les réalités socio-économiques actuelles, la FLASH, qui repose sur l’engagement d’un corps professoral et administratif dynamique, propose à ses étudiants un cursus universitaire varié en relation avec l’univers professionnel. En outre, c’est un établissement qui se donne pour objectif de promouvoir la recherche transdisciplinaire.</p>`,
            'masterLink': 'http://example.com/preinscription-master-flash',
            'licenceLink': 'http://example.com/preinscription-licence-flash'
        },
        'esef': {
            'img': 'images/logo-esef.jpg',
            'title': 'ESEF',
            'description': `<p>L'Ecole Supérieure d’Education et de Formation de Berrechid (ESEFB), rattachée à l'Université Hassan 1er, a été fondée dans le cadre d'une stratégie de proximité initiée par cette dernière. Cette démarche s'inscrit également dans une perspective plus large, en adhérant aux grands projets nationaux définis dans la vision stratégique 2015-2030 et la nouvelle loi-cadre 51.17. L'ESEFB répond ainsi à un besoin crucial en formant des enseignants qualifiés, dotés des compétences professionnelles requises pour répondre aux besoins évolutifs du secteur éducatif, tant au niveau primaire que secondaire. Cette initiative vise à renforcer l'employabilité des diplômés tout en contribuant à l'amélioration de la qualité de l'enseignement au Maroc.</p>
            <p>En plaçant la formation des enseignants au cœur de ses priorités, l'ESEFB joue un rôle essentiel dans la réalisation des objectifs stratégiques de l'Université Hassan 1er. En formant des professionnels de l'éducation compétents et bien préparés, l'école participe activement à la mise en œuvre des réformes éducatives et à la promotion d'une éducation de qualité à tous les niveaux. Cette approche visionnaire et engagée illustre l'engagement de l'ESEFB envers l'excellence académique et sa contribution à la construction d'un système éducatif solide et dynamique au Maroc.</p>`,
            'masterLink': 'http://example.com/preinscription-master-esef',
            'licenceLink': 'http://example.com/preinscription-licence-esef'
        },
        'ensa': {
            'img': 'images/logo-ensa.png',
            'title': 'ENSA',
            'description': `<p>Depuis sa création en 1994, l’École Nationale de Commerce et de Gestion de Settat s'est fixée pour mission de répondre aux besoins croissants du marché de l'emploi dans les secteurs de la gestion et du commerce. Son engagement envers la formation de cadres compétents capables de relever les défis de compétitivité du système productif national est indéniable. Grâce à une ingénierie pédagogique de premier plan, une recherche scientifique reconnue et un réseau étendu de coopérations académiques et scientifiques, l'ENCG Settat a su consolider sa position de leader en tant qu'école d'excellence en Afrique. La rigueur dans la sélection des enseignants, du personnel administratif et des étudiants, ainsi que le soutien continu de la Présidence de l'Université Hassan Premier et des autorités locales, ont permis de créer des synergies fructueuses favorisant le développement continu de l'école et son rayonnement national et international.</p>
            <p>Grâce à ses solides fondations et à son engagement envers l'excellence, l’École Nationale de Commerce et de Gestion de Settat poursuit sa mission avec détermination. En formant des professionnels hautement qualifiés et en leur offrant les outils nécessaires pour réussir dans un environnement professionnel compétitif, l'école contribue activement à l'avancement du paysage économique et commercial du Maroc. Son positionnement en tant que référence académique et institution d'enseignement supérieur régulé confirme son rôle crucial dans la formation de la prochaine génération de leaders et d'entrepreneurs. En mettant l'accent sur l'innovation pédagogique, la recherche de pointe et le développement de partenariats stratégiques, l'ENCG Settat continue d'inspirer l'excellence et de façonner l'avenir du commerce et de la gestion dans la région et au-delà.</p>`,
            'masterLink': 'http://example.com/preinscription-master-ensa',
            'licenceLink': 'http://example.com/preinscription-licence-ensa'
        }
    };

    const establishmentLinks = document.querySelectorAll('.establishment-links li');
    const establishmentDetails = document.getElementById('establishment-details');

    establishmentLinks.forEach(link => {
        link.addEventListener('click', function () {
            establishmentLinks.forEach(el => el.classList.remove('active'));
            this.classList.add('active');
            const id = this.getAttribute('data-id');
            loadEstablishment(id);
        });
    });

    function loadEstablishment(id) {
        const establishment = establishments[id];
        establishmentDetails.innerHTML = `
            <div class="establishment-details active">
                <img src="${establishment.img}" alt="${establishment.title} Logo">
                <h3>${establishment.title}</h3>
                <p>${establishment.description}</p>
                <div class="buttons">
                    <a href="${establishment.masterLink}" class="btn btn-primary">Master</a>
                    <a href="${establishment.licenceLink}" class="btn btn-secondary">Licence</a>
                </div>
            </div>
        `;
        setTimeout(() => {
            establishmentDetails.querySelector('.establishment-details').classList.add('active');
        }, 100);
    }

    // Load the first establishment by default and set the first link as active
    const firstLink = document.querySelector('.establishment-links li.active');
    if (firstLink) {
        loadEstablishment(firstLink.getAttribute('data-id'));
    }




    
});




