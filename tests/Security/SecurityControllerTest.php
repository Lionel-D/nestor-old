<?php

namespace App\Tests\Security;

use App\Tests\ProjectTestCase;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class SecurityControllerTest
 * @package App\Tests
 * @author  Lionel DAELEMANS <hello@lionel-d.com>
 */
class SecurityControllerTest extends ProjectTestCase
{
    public function testLoginSuccessful()
    {
        $crawler = $this->successfullyLoadLoginPage();

        $this->fillAndSubmitLoginForm($crawler, 'john@doe.com', 'password');

        $this->assertResponseRedirects('/app/dashboard');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Hello AppDashboardController!');
    }

    public function testLoginFailedWrongPassword()
    {
        $crawler = $this->successfullyLoadLoginPage();

        $this->fillAndSubmitLoginForm($crawler, 'john@doe.com', 'wrongpassword');

        $this->assertResponseRedirects('/login');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('.form-error-message', 'Invalid credentials.');
    }

    public function testLoginFailedNoAccount()
    {
        $crawler = $this->successfullyLoadLoginPage();

        $this->fillAndSubmitLoginForm($crawler, 'fake@email.com', 'azerty');

        $this->assertResponseRedirects('/login');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('.form-error-message', 'Email could not be found.');
    }

    public function testLoginAsAlreadyAuthenticated()
    {
        $this->assertLoggedAsUser();

        $this->client->request('GET', '/login');

        $this->assertResponseRedirects('/app/dashboard');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Hello AppDashboardController!');
    }

    public function testLogout()
    {
        $this->assertLoggedAsUser();

        $this->client->request('GET', '/logout');

        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Hello HomeController!');
    }

    public function testRegisterFailedNoName()
    {
        $crawler = $this->successfullyLoadRegisterPage();

        $this->fillAndSubmitRegisterForm($crawler, '', 'new@user.com', '1newpa$$', true);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.form-error-message', 'Please choose a name.');
    }

    public function testRegisterFailedNoEmail()
    {
        $crawler = $this->successfullyLoadRegisterPage();

        $this->fillAndSubmitRegisterForm($crawler, 'NewUser', '', '1newpa$$', true);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.form-error-message', 'You must enter an email.');
    }

    public function testRegisterFailedInvalidEmail()
    {
        $crawler = $this->successfullyLoadRegisterPage();

        $this->fillAndSubmitRegisterForm($crawler, 'NewUser', 'toto', '1newpa$$', true);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.form-error-message', 'This is not a valid email.');
    }

    public function testRegisterFailedEmailAlreadyUsed()
    {
        $crawler = $this->successfullyLoadRegisterPage();

        $this->fillAndSubmitRegisterForm($crawler, 'NewUser', 'hello@lionel-d.com', '1newpa$$', true);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.form-error-message', 'There is already an account with this email.');
    }

    public function testRegisterFailedNoPassword()
    {
        $crawler = $this->successfullyLoadRegisterPage();

        $this->fillAndSubmitRegisterForm($crawler, 'NewUser', 'new@user.com', '', true);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.form-error-message', 'Please choose a password.');
    }

    public function testRegisterFailedPasswordTooShort()
    {
        $crawler = $this->successfullyLoadRegisterPage();

        $this->fillAndSubmitRegisterForm($crawler, 'NewUser', 'new@user.com', '1a$', true);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.form-error-message', 'Your password should be at least 8 characters long.');
    }

    public function testRegisterFailedPasswordWithoutLetter()
    {
        $crawler = $this->successfullyLoadRegisterPage();

        $this->fillAndSubmitRegisterForm($crawler, 'NewUser', 'new@user.com', '$1234567', true);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.form-error-message', 'Your password must contain at least one letter.');
    }

    public function testRegisterFailedPasswordWithoutDigit()
    {
        $crawler = $this->successfullyLoadRegisterPage();

        $this->fillAndSubmitRegisterForm($crawler, 'NewUser', 'new@user.com', '$abcdefg', true);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.form-error-message', 'Your password must contain at least one digit.');
    }

    public function testRegisterFailedPasswordWithoutSymbol()
    {
        $crawler = $this->successfullyLoadRegisterPage();

        $this->fillAndSubmitRegisterForm($crawler, 'NewUser', 'new@user.com', '1234567x', true);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.form-error-message', 'Your password must contain at least one symbol.');
    }

    public function testRegisterFailedTermsNotAgreed()
    {
        $crawler = $this->successfullyLoadRegisterPage();

        $this->fillAndSubmitRegisterForm($crawler, 'NewUser', 'new@user.com', '1newpa$$', false);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.form-error-message', 'You should agree to our terms.');
    }

    public function testRegisterSuccessful()
    {
        $crawler = $this->successfullyLoadRegisterPage();

        $this->fillAndSubmitRegisterForm($crawler, 'NewUser', 'new@user.com', '1newpa$$', true);

        $this->assertResponseRedirects('/app/dashboard');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Hello AppDashboardController!');
    }

    /**
     * @return Crawler
     */
    private function successfullyLoadLoginPage()
    {
        $crawler = $this->client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.card-header', 'Please sign in');

        return $crawler;
    }

    /**
     * @param Crawler $crawler
     * @param string  $email
     * @param string  $password
     */
    private function fillAndSubmitLoginForm(Crawler $crawler, $email, $password)
    {
        $form = $crawler->selectButton('login_submit')->form();

        $form['email']    = $email;
        $form['password'] = $password;

        $this->client->submit($form);
    }

    /**
     * @return Crawler
     */
    private function successfullyLoadRegisterPage()
    {
        $crawler = $this->client->request('GET', '/register');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.card-header', 'Register');

        return $crawler;
    }

    /**
     * @param Crawler $crawler
     * @param string  $name
     * @param string  $email
     * @param string  $password
     * @param bool    $terms
     */
    private function fillAndSubmitRegisterForm(Crawler $crawler, $name, $email, $password, $terms)
    {
        $form = $crawler->selectButton('register_submit')->form();

        $form['registration_form[name]']          = $name;
        $form['registration_form[email]']         = $email;
        $form['registration_form[plainPassword]'] = $password;

        if ($terms) {
            $form['registration_form[agreeTerms]'] = "1";
        }

        $this->client->submit($form);
    }
}
