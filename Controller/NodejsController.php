<?php

namespace Briareos\NodejsBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Briareos\NodejsBundle\Entity\NodejsPresence;
use Briareos\NodejsBundle\Entity\NodejsSubjectInterface;

class NodejsController extends ContainerAware
{

    /**
     * @Route("/nodejs/message", name="nodejs_message")
     *
     * @throws AccessDeniedException
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function messageAction()
    {
        /** @var $dispatcher \Briareos\NodejsBundle\Nodejs\DispatcherInterface */
        $dispatcher = $this->container->get('nodejs.dispatcher');
        /** @var $authenticator \Briareos\NodejsBundle\Nodejs\Authenticator */
        $authenticator = $this->container->get('nodejs.authenticator');
        /** @var $request \Symfony\Component\HttpFoundation\Request */
        $request = $this->container->get('request');

        if ($dispatcher->getServiceKey() !== $request->request->getAlnum('serviceKey', '')) {
            throw new AccessDeniedException('Invalid service key provided.');
        }
        $message = json_decode($request->request->get('messageJson'));
        $responseData = array();

        switch ($message->messageType) {
            case 'authenticate':
                $presence = $authenticator->getPresence($message->authToken);
                $channels = array();
                $authenticated = false;
                $subjectId = 0;
                $presenceSubjectIds = array();

                if ($presence instanceof NodejsPresence) {
                    $authenticated = true;
                    if ($presence->getSubject() instanceof NodejsSubjectInterface) {
                        $subjectId = $presence->getSubject()->getId();
                    }
                }
                $channels[] = "user_$subjectId";

                $responseData = array(
                    'serviceKey' => $dispatcher->getServiceKey(),
                    'authToken' => $message->authToken,
                    'clientId' => $message->clientId,
                    'nodejsValidAuthToken' => $authenticated,
                    'channels' => $channels,
                    'presenceUids' => $presenceSubjectIds,
                    'uid' => $subjectId,
                    'contentTokens' => isset($message->contentTokens) ? $message->contentTokens : array(),
                );
                break;
            case 'userOffline':
                // $message['uid'] has went offline, or just refreshed his browser.
                break;
            default:
                throw new AccessDeniedException(sprintf('Invalid message type: %s', $message->messageType));
        }

        $response = new Response(json_encode($responseData));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('NodejsServiceKey', $dispatcher->getServiceKey());
        return $response;
    }
}