# Node.js bundle for Symfony2

This module integrates Node.js with a Symfony2 project.

It provides an API that other bundles can use to add realtime capabilities your application, specifically enabling
pushing updates to open connected clients.

## Instructions

1.  Your user class must implement `Briareos\NodejsBundle\Entity\NodejsSubjectInterface`

    >Note that you don't have to implement `Briareos\NodejsBundle\Entity\NodejsSubjectInterface` if your user class already
    implements `Briareos\ChatBundle\Entity\ChatSubjectInterface`, since the later extends the former.

1.  Map the interface to your user bundle, so that relationships can work

        # app/config/config.yml
        doctrine:
            orm:
                resolve_target_entities:
                    Briareos\NodejsBundle\Entity\NodejsSubject: App\UserBundle\Entity\User

1.  Update your schema

        $ php app/console doctrine:schema:update --force

1.  Install the required Node.js packages, `socket.io`, `connect` and `express`, and all their dependencies.

        $ npm install -g socket.io express

    >Note: the *express* package must be version 3.0beta5 or newer.

1.  On places that you would like to use Node.js and connect the user to the server include `BriareosNodejsBundle:Nodejs:nodejs.html.twig`
    or use your own implementation. This must be done before including any JavaScripts that extend or depend on this bundle.