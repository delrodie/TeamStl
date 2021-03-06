==================================
===== BACKOFFICE DES WEBSITE =====
==================================

/*****
*** @Author: Delrodie AMOIKON
*** @version: 1.0.*
*** @Date: Mercredi 02 Novembre 2016
*****/

Ce projet consiste à concevoir le backoffice de mes sites
Il est composé de 5 tables dans la base ded données dont
  - RUBRIQUE: pour la gestion des categories d'articles
  - ARTICLES: pour la gestion des contenus des rubriques
  - IMAGE: pour la gestion des images d'illustration des articles et de la galerie photo
  - UTILISATEURS: pour la gestion des auteurs des articles
  - GROUPE: pour la gestion des groupe d'utilisateurs

Ainsi nous avons comme MLD
** - [*- RUBRIQUE(titre, description, statut)
         IMAGE(url, alt, statut)
         GROUPE(nom, role)
         UTILISATEUR(nom, login, motpass, mail, contact, #groupe)
         ARTICLE(titre, resume, contenu, tags, date_publication, date_modification, statut, #rubrique, #image, #auteur)
     -*]


1°/ **Implementation du template dans la base**
    Création du layout du backoffice dans App/resources/view
    ** - [*app/Resources/view/layout.html.twig*]

2°/ **Integration du bundle BazingaFakerBundle**
    Insertion dans composer.json
    ** - [*"require": {
              ...
              "willdurand/faker-bundle": "@stable"
          },*]

    Mise a jour du composer
    ** - [*composer update*]

    Activation du Bundle dans AppKernel
    [*if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
        ...
        $bundles[] = new Bazinga\Bundle\FakerBundle\BazingaFakerBundle();
    }*]

    Configuration dans config.yml
    [*bazinga_faker:
        orm: doctrine
        locale: fr_FR
        entities:*]

3°/ **Gestion de la classe Rurbique**
    Generation de l'entité Rubrique
    ** - [*- php bin/console doctrine:generate:entity AppBundle:Rubrique -*]

    Mise a jour de la base de données
    ** - [*- php bin/console doctrine:schema:update --force -*]

    Generation CRUD de l'entité Rubrique
    ** - [*- php bin/console doctrine:generate:crud AppBundle:Rubrique -*]

    Insertion des valeurs dans la table rubrique
    ** - [*- php bin/console faker:populate -*]

    Mise en page des templates (rubrique/new.html.twig, rubrique/index.html.twig, rubrique/edit.html.twig)

    Modification du form RubriqueType();
    ** - [*- $builder
          ->add('titre', TextType::class, array(
                'attr'  => array(
                    'class' => 'form-control'
                )
          ))
          ->add('description', TextareaType::class, array(
                'attr'  => array(
                    'class' => 'form-control'
                )
          ))
          ->add('statut')
          ; -*]

4°/ **Gestion de la classe Article**
    Generation de l'entité Article
    ** - [*- php bin/console doctrine:generate:entity AppBundle:Article -*]*

    Integration des lifeCycleCallbacks
    ** - [*- * @ORM\HasLifecycleCallbacks -*]
         [*-
             /**
             * @ORM\PrePersist
             */
             public function setPublicationAtValue()
             {
                $this->publicationAt = new \DateTime();
             }

             /**
             * @ORM\PreUpdate
             */
             public function setModificationAtValue()
             {
                $this->modificationAt = new \DateTime();
             }
          -*]

    Mise en relation avec l'entité Rubrique
    ** - [*-
            /**
             * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Rubrique")
             * @ORM\JoinTable(name="articles_rubriques",
             *      joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id")},
             *      inverseJoinColumns={@ORM\JoinColumn(name="rubrique_id", referencedColumnName="id")}
             *      )
             */
             private $rubriques;
         -*]

    Mise a jour de la base de données
    ** - [*- php bin/console doctrine:schema:update --force -*]

    Generation crud de l'entité Article
    ** - [*- php bin/console doctrine:generate:crud AppBundle:Article -*]

    Mise en page de page des différentes views de article

5°/ **Gestion de la classe image**
    Generation de la classe
    ** - [*- php bin/console doctrine:generate:entity AppBundle:Image -*]

    Mise a jour de la base de données
    ** - [*- php bin/console doctrine:schema:update --force -*]

    Generation crud de l'entité Image
    ** - [*- php bin/console doctrine:generate:crud AppBundle:Image -*]

    Modification pour upload de l'image

    Mise en relation Article/Image
    ** - [*-
            /**
             * @ORM\OneToOne(targetEntity="AppBundle\Entity\Image", cascade={"persist", "remove"})
             */
             private $image;
         -*]

    Mise a jour de la classe Article
    ** - [*- php bin/console doctrine:generate:entities AppBundle:Article -*]

    Mise a jour de la base de données
    ** - [*- php bin/console doctrine:schema:update --force -*]

    Integration de classe Image et ImageType dans ArticleType
    ** - [*-  use AppBundle\Entity\Image;
              use AppBundle\Form\ImageType;

              $builder
                    ...
                  ->add('image', ImageType::class)
              ;
        -*]

6°/ **Gestion des utilisateurs**
    Installation de FOSUserBundle
    ** - [*- composer require friendsofsymfony/user-bundle "~2.0@dev" -*]

    Activation du bundle dans AppKernel
    ** - [*- $bundles = [
            ...
            new FOS\UserBundle\FOSUserBundle(),
            ];
          -*]

    Creation des classe User.php et Group.php

    Personnalisation de la page de connexion

    Insertion des attributs
    loginCount: pour le nombre de connexion de l'utilisateur
    ** - [*- /**
             * @ORM\Column(type="integer", length=6, options={"default":0})
             */
            protected $loginCount = 0;
          -*]
    firstLogin: pour la première connexion
    ** - [*- /**
             * @var \DateTime
             *
             * @ORM\Column(type="datetime", nullable=true)
             */
            protected $firstLogin;
          -*]

    Mise a jour de la base de donnée
    ** - [*- php bin/console doctrine:cache:clear-metadata -*]
         [*- php bin/console doctrine:schema:update --force -*]

    Enregistrement de notre ecouteur de connexion
    ** - [*- services:
                login_listener:
                    class: 'AppBundle\Listener\LoginListener'
                    arguments: ['@fos_user.user_manager']
                    tags:
                        - { name: 'kernel.event_listener', event: 'security.interactive_login' }
                        - { name: 'kernel.listener', event: 'fos_user.security.implicit_login' }
          -*]

    Creation de notre ecouteur
    AppBundle\Listener\LoginListener.php

    Gestion de la classe Groupe
    ** - [*- php bin/console doctrine:generate:crud AppBundle:Group -*]

    Sauvegarde des entités (copie de repertoire AppBundle\Entity)

    Récupération des informations de mise en correspondance des entité tables
    ** - [*- php bin/console doctrine:mapping:import "AppBundle" xml -*]

    Modification de la classe GroupType
    ** - [*-
            $builder
                ->add('name', TextType::class, array(
                      'attr'  => array(
                          'class' => 'form-control'
                      )
                ))
                ->add('roles', ChoiceType::class, array(
                      'choices' => array(
                        'Auteur'  => 'ROLE_AUTEUR',
                        'Administrateur'  => 'ROLE_ADMIN'
                      ),
                      'multiple'  => true,
                      'expanded'  => true
                ))
                ;
          -*]

    Mise en page de l'entité Groupe
      creation de de template pour affichage des roles a cocher
      app/Resources/views/form/fields.html.twig

    Mise en page de l'entité User

7°/ **Installation de StofDoctrineExtensionsBundle**
    Installation de StofDoctrineExtensionsBundle
    ** - [*- https://github.com/Atlantic18/DoctrineExtensions/blob/master/doc/symfony2.md -*]



/*****
 *** Gestion du site de TEAM STL
 *** @Author: Delrodie AMOIKON
 *** @version: 1.1.*
 *** @Date: Lundi 23 Janvier 2017
 *****/

1°/ **Gestion de la rubrique Presentation**
    Creation des classes Presentation et ImgPresentation
    ** - [*- php bin/console doctrine:genrate:entity AppBundle:Presentation/Imgpresentation -*]

    Generation CRUD des classes Presentation et ImgPresentation
    ** - [*- php bin/console doctrine:generate:crud AppBundle:Presentation/Imgpresentation -*]

    Mise en page des templates de la classe Presentation presentation/new-index-show .html.twig

    Modification du routing pour integration du routing du menu presentation dans config/routing.yml
    ** - [*-
            menu_presentation:
                path:     /menu/presentation
                defaults: { _controller: "AppBundle:Menu:presentation" }
                methods:  [GET, POST]
          -*]

    Creation de la classe MenuController dans AppBundle/Controler

    Insertion du render menu dans le layout
    ** - [*-
            {% for presentation in presentations %}
                <li><a href="{{ path('admin_presentation_show', { 'slug': presentation.slug }) }}">{{ presentation.rubrique|upper }}</a></li>
            {% endfor %}
         -*]


2°/ **Gestion de la rubrique initiation**
    Creation des classes Initions et ImgInitiation
    ** - [*- php bin/console doctrine:generate:entity AppBundle:Initiation/ImgInitiation -*]

    Mise a jour de la base de données
    ** - [*- php bin/console doctrine:schema:update --force -*]

    Generation CRUD des classes ImgInitiation et Initiation
    ** - [*- php bin/console doctrine:generate:crud AppBundle:ImgInitiation -*]

    Modification de la classe ImgInitiationType
    ** - [*-
            use Symfony\Component\Form\Extension\Core\Type\FileType;
            ...
            $builder
                ->add('file', FileType::class, array(
                    'label' => "Telecharger l'illustration",
                    'required' => false,
                ))
                ;
          -*]

    Generation Crud de la classe Initiation
    ** - [*- php bin/console doctrine:generate:crud AppBundle:Initiation -*]

    Creation du menu de la classe Initiation
    - Dans le layout
    ** - [*- {{ render(url('menu_initiation')) }} -*]
    - Modification du MenuController avec insertion de la classe InitiationController
    - Creation de la route menu_initiation dans config/routing.yml
    ** - [*-
            menu_initiation:
                path:     /menu/initiation
                defaults: { _controller: "AppBundle:Menu:initiation" }
                methods:  [GET, POST]
          -*]
    - Creation du template menu/initiation.html.twig
    ** - [*-
          {% for initiation in initiations %}
              <li><a href="{{ path('admin_initiation_show', { 'slug': initiation.slug }) }}">{{ initiation.rubrique|upper }}</a></li>
          {% endfor %}

          -*]

3°/ **Gestion de la classe Academy**
    creation des classe Academy et imgAcademy
    ** - [*- php bin/console doctrine:generate:entity AppBundle:Academy/ImgAcademy -*]

    Mise a jour de la base de données
    ** - [*- php bin/console doctrine:schema:update --force -*]

    Generation CRUD de la classe ImgAcademy
    ** - [*- php bin/console console doctrine:generate:crud AppBundle:ImgAcademy -*]

    Generation CRUD de la classe Academy
    ** - [*- php bin/console doctrine:generate:crud AppBundle:Academy -*]

    Modification de la classe AcademyType

    Mise a jour des templates academy/new-show-edit .html.twig

    Creation du menu
    - creation de la route dans config/routing.yml
    ** [*-
        menu_academy:
            path:     /menu/academy
            defaults: { _controller: "AppBundle:Menu:academy" }
            methods:  [GET, POST]
        -*]
    - creation du controller de gestion dans MenuController:academyAction
    ** - [*-
            public function academyAction()
            {
                $em = $this->getDoctrine()->getManager();          
                $academys = $em->getRepository('AppBundle:Academy')->findAll();          
                return $this->render('menu/academy.html.twig', array(
                    'academys' => $academys,
                ));
            }
          -*]
    - creation du template menu/academy.html.twig
    ** - [*-
            {% for academy in academys %}
                <li><a href="{{ path('admin_academy_show', { 'slug': academy.slug }) }}">{{ academy.rubrique|upper }}</a></li>
            {% endfor %}
          -*]
    - Insertion dans le layout
    ** - [*- {{ render(url('menu_academy')) }} -*]

4°/ **Gestion de la classe Societe**
    Creation des classes Societe
    ** - [*- php bin/console doctrine:generate:entity AppBundle:Societe -*]

    Mise a jour de la base de données
    ** - [*- php bin/console doctrine:schema:update --force -*]

    Generation CRUD de la classe Societe
    ** - [*- php bin/console dcotrine:generate:crud AppBundle:Societe -*]

    Modification de la classe SocieteType
    Mise a jour des templates academy/new-show-edit .html.twig

5°/ **Gestion de la classe Competition**
    Creation des classes Competition et ImgCompetition
    ** - [*- php bin/console doctrine:generate:entity AppBundle:Competition/ImgCompetition -*]

    Mise a jour de la base de données
    ** - [*- php bin/console doctrine:schema:update --force -*]

    Generation CRUD de la classe ImgCompetition
    ** - [*- php bin/console doctrine:generation:CRUD AppBundle:ImgCompetition -*]

    Modification de la classe Form/ImgcompetitionType

    Generation crud de la classe Competition
    ** - [*- php bin/console doctrine:generate:CRUD AppBundle:Competition -*]

    Ajout des attributs a l'entité
    ** - [*-
            Journee(boolean)
            Periode(boolean)
          -*]

    Mise a jour de la classe Competition et de la base de données
    ** - [*-
            php bin/console doctrine:generate:entities AppBundle:Competition
            php bin/console doctrine:schema:update --force
          -*]

    Creation du menu
    - Creation de la route dans config/routing.yml
    ** - [*-
            menu_competition:
                path:     /menu/competition
                defaults: { _controller: "AppBundle:Menu:competition" }
                methods:  [GET, POST]
          -*]

    - Creation du controller de gestion dans MenuController:competitionAction
    ** - [*-
            public function competitionAction()
            {
                $em = $this->getDoctrine()->getManager();          
                $competitions = $em->getRepository('AppBundle:Competition')->findAll();          
                return $this->render('menu/competition.html.twig', array(
                    'competitions' => $competitions,
                ));
            }
          -*]
    - Creation du template menu/competition.html.twig
    ** - [*-
            {% for competition in competitions %}
                <li><a href="{{ path('admin_competition_show', { 'slug': competition.slug }) }}">{{ competition.rubrique|upper }}</a></li>
            {% endfor %}
          -*]
    - Insertion dans le layout
    ** - [*- {{ render(url('menu_competition')) }} -*]

    Creation de la page calendrier des competitions
    - Creation du controller DefaultController:calendrierAction
    ** - [*-
            public function calendrierAction()
            {
                $em = $this->getDoctrine()->getManager();
                $competitions = $em->getRepository('AppBundle:Competition')->getAdmincalendrier();
                return $this->render('competition/calendrier.html.twig', array(
                    'competitions' => $competitions,
                ));
            }
          -*]
    - Creation du repository dans CompetitionRepository:getAdmincalendrier
    ** - [*-
            public function getAdmincalendrier()
            {
                $em = $this->getEntityManager();
                $qb = $em->createQuery('
                    SELECT c
                    FROM AppBundle:Competition c
                    ORDER BY c.datedeb DESC
                ')
                ;
                try {
                    $result = $qb->getResult();
                    return $result;
                } catch (NoResultException $e) {
                    return $e;
                }
            }
          -*]
    - Creation du template de competition/calendrier.html.twig

6°/ **Gestion de la classe Evenement**
    Creation de la classe Evenement
    ** - [*- php bin/console doctrine:generate:entity AppBundle:Evenement -*]

    Mise a jour de la base de donnée
    ** - [*- php bin/console doctrine:schema:update --force -*]

    Generation CRUD de la classe Evenement
    ** - [*- php bin/console doctrine:generate:crud AppBundle:Evenement -*]


7°/ **Gestion de la classe Phototheque**
    Creation des classes Phototheque et ImgPhototheque
    ** - Phototheque(titre, description, url, slug, publication, modification, statut)
    ** - [*- php bin/console doctrine:generate:entity AppBundle:Phototheque/ImgPhototheque -*]

    Generation CRUD de la classe ImgPhototheque
    ** - [*- php bin/console doctrine:generate:crud AppBundle:ImgPhototheque -*]

    Modification du formulaire ImgPhotothequeType

    Generation CRUD de la classe Phototheque
    ** - [*- php bin/console doctrine:generate:crud AppBundle:Phototheque -*]

8°/ **Gestion de la classe Videotheque**
    Creation de la classe Videotheque
    ** - Videotheque(titre, description, url, slug, publication, modification, statut)
    ** - [*- php bin/console doctrine:generate:enitity AppBundle:Videotheque -*]

/**********
 *** Integration du frontoffice du site
 *** @Author Delrodie AMOIKON
 *** @Date 31-01-2017
***********/

1°/ Layout du front office
    - Integration des ressources foundation dans le repertoire web/ressources
    - Creation du fichier FOLayout.html.twig

2
