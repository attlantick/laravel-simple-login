<?php

namespace Tests\Browser;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterFormTest extends DuskTestCase
{
    /**
     * Test
     * @throws \Throwable
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $faker = Factory::create();
            $browser->visit('/')
                ->assertSee('Sign Up')
                ->type('#name','Attlantick')
                ->type('#email','attlantick@asd')
                ->type('#phone','123 123-123')
                ->screenshot('register-invalid-forms')
                ->assertPresent('.is-invalid#email')
                ->assertPresent('.is-invalid#phone');

            $browser
                //generate random email
                ->type('#email',$faker->email)
                //generate random phone with format like '(888) 937-7238'
                ->type('#phone',$faker->tollFreePhoneNumber)
                ->screenshot('register-valid-forms')
                ->assertPresent('.is-valid#email')
                ->assertPresent('.is-valid#phone');

            $browser->type('#zip','12345')
                ->type('#address','My Address')
                ->attach('#photo', __DIR__.'/files/document.txt');//incorrect file type for photo

            $this->assertNull($browser->element('.img-thumbnail'));

            $browser
                ->attach('#photo', __DIR__.'/files/image.png')  //correct image type
                ->attach('#file', __DIR__.'/files/document.txt')
                ->screenshot('register-before-send');
            $browser->click('button.btn-primary')
                ->screenshot('register-result')
                ->assertDialogOpened('Success');
        });
    }
}
