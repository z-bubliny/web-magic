<?php

namespace App\Presenters;

use ZBubliny\Model\Service\UsersModel;

class LoginPresenter extends BasePresenter
{

    /** @var \Kdyby\Facebook\Facebook */
    private $facebook;

    /** @var UsersModel */
    private $usersModel;

    /**
     * You can use whatever way to inject the instance from DI Container,
     * but let's just use constructor injection for simplicity.
     *
     * Class UsersModel is here only to show you how the process should work,
     * you have to implement it yourself.
     */
    public function __construct(\Kdyby\Facebook\Facebook $facebook, UsersModel $usersModel)
    {
        parent::__construct();
        $this->facebook = $facebook;
        $this->usersModel = $usersModel;
    }


    /** @return \Kdyby\Facebook\Dialog\LoginDialog */
    protected function createComponentFbLogin()
    {
        $dialog = $this->facebook->createDialog('login');
        /** @var \Kdyby\Facebook\Dialog\LoginDialog $dialog */

        $dialog->onResponse[] = function (\Kdyby\Facebook\Dialog\LoginDialog $dialog) {
            $fb = $dialog->getFacebook();

            if (!$fb->getUser()) {
                $this->flashMessage("Sorry bro, facebook authentication failed.");
                return;
            }

            /**
             * If we get here, it means that the user was recognized
             * and we can call the Facebook API
             */

            try {
                $me = $fb->api('/me');

                if (!$existing = $this->usersModel->findByFacebookId($fb->getUser())) {
                    /**
                     * Variable $me contains all the public information about the user
                     * including facebook id, name and email, if he allowed you to see it.
                     */
                    $existing = $this->usersModel->registerFromFacebook($fb->getUser(), $me);
                }

                /**
                 * You should save the access token to database for later usage.
                 *
                 * You will need it when you'll want to call Facebook API,
                 * when the user is not logged in to your website,
                 * with the access token in his session.
                 */
                $this->usersModel->updateFacebookAccessToken($fb->getUser(), $fb->getAccessToken());

                /**
                 * Nette\Security\User accepts not only textual credentials,
                 * but even an identity instance!
                 */
                $this->user->login(new \Nette\Security\Identity($existing->id, $existing->roles, $existing));

                /**
                 * You can celebrate now! The user is authenticated :)
                 */

            } catch (\Kdyby\Facebook\FacebookApiException $e) {
                /**
                 * You might wanna know what happened, so let's log the exception.
                 *
                 * Rendering entire bluescreen is kind of slow task,
                 * so might wanna log only $e->getMessage(), it's up to you
                 */
                \Tracy\Debugger::log($e, 'facebook');
                $this->flashMessage("Sorry bro, facebook authentication failed hard.");
            }

            $this->redirect('this');
        };

        return $dialog;
    }

}
