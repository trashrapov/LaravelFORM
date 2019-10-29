<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FormSubmissionTest extends DuskTestCase
{
    /**
     * Correctly fiiled form submission test
     *
     * @return void
     */
    public function testExample()
    {
       
        $email = bin2hex(random_bytes(5)) . '@gmail.com';

        $this->browse(function (Browser $browser) {

        /*************Variables*************/
            /*
            *   always create new email.
            *   email should be unique in DB!!!
            */
            $email = bin2hex(random_bytes(5)) . '@gmail.com';

            /*
            *   
            *   specify your file path for test uploading!!!
            */
            $filepath = __DIR__.'/../../storage/app/public/files/5hupZkzlioP2FanvpqOhSOmxTDT9xMDw9yzKIcPM.png';

            /*
            *   
            *   specify your file path for wrongFormat test uploading!!!
            */
            $wrongFormatFilePath = __DIR__.'/../../storage/app/public/files/file.php';

        /*************Testing*************/

            /*
            *   
            *   Correctly filled form test
            *  
            */
            $browser->visit('/')
                    ->type('name', 'my_name')
                    ->type('email', $email)
                    ->type('phone', '(123)-456-7899')
                    ->type('address', '123 Main st.')
                    ->type('zipCode', '12345')
                    ->attach('file', $filepath)
                    ->click('#submitButton')
                    ->waitForText('Record successfully created!')
                    ->assertSee('Record successfully created!');

            /*
            *   
            *  Email duplicated (already exists in db)
            *  
            */        
            $browser->visit('/')
                    ->type('name', 'my_name')
                    ->type('email', $email)
                    ->type('phone', '(123)-456-7899')
                    ->type('address', '123 Main st.')
                    ->type('zipCode', '12345')
                    ->attach('file', $filepath)
                    ->click('#submitButton')
                    ->waitForText('The email has already been taken')
                    ->assertSee('The email has already been taken');

            /*
            *   
            *  Empty form submission
            *  
            */        
            $browser->visit('/')                    
                    ->click('#submitButton')
                    ->waitForText('Name field is required!')
                    ->assertSeeIn('#nameError', 'Name field is required!')
                    ->assertSeeIn('#emailError', 'Email field is required!')
                    ->assertSeeIn('#phoneError', 'Phone field is required!')
                    ->assertSeeIn('#addressError', 'Address field is required!')
                    ->assertSeeIn('#zipCodeError', 'ZipCode field is required!')
                    ->assertSeeIn('#fileError', 'File field is required!');

            /*
            *   
            *  Empty name field submission
            *  
            */        
            $browser->visit('/')                    
                    ->type('email', $email)
                    ->type('phone', '(123)-456-7899')
                    ->type('address', '123 Main st.')
                    ->type('zipCode', '12345')
                    ->attach('file', $filepath)
                    ->click('#submitButton')
                    ->waitForText('Name field is required!')
                    ->assertSee('Name field is required!');

            /*
            *   
            *  Empty email field submission
            *  
            */        
            $browser->visit('/')                    
                    ->type('name', 'my_name')
                    ->type('phone', '(123)-456-7899')
                    ->type('address', '123 Main st.')
                    ->type('zipCode', '12345')
                    ->attach('file', $filepath)
                    ->click('#submitButton')
                    ->waitForText('Email field is required!')
                    ->assertSee('Email field is required!');

            /*
            *   
            *  Empty phone field submission
            *  
            */        
            $browser->visit('/')                    
                    ->type('name', 'my_name')
                    ->type('email', $email)
                    ->type('address', '123 Main st.')
                    ->type('zipCode', '12345')
                    ->attach('file', $filepath)
                    ->click('#submitButton')
                    ->waitForText('Phone field is required!')
                    ->assertSee('Phone field is required!');

            /*
            *   
            *  Empty address field submission
            *  
            */        
            $browser->visit('/')                    
                    ->type('name', 'my_name')
                    ->type('email', $email)
                    ->type('phone', '(123)-456-7899')
                    ->type('zipCode', '12345')
                    ->attach('file', $filepath)
                    ->click('#submitButton')
                    ->waitForText('Address field is required!')
                    ->assertSee('Address field is required!');

            /*
            *   
            *  Empty zipCode field submission
            *  
            */        
            $browser->visit('/')                    
                    ->type('name', 'my_name')
                    ->type('email', $email)
                    ->type('phone', '(123)-456-7899')
                    ->type('address', '123 Main st.')
                    ->attach('file', $filepath)
                    ->click('#submitButton')
                    ->waitForText('ZipCode field is required!')
                    ->assertSee('ZipCode field is required!');

            /*
            *   
            *  Empty zipCode field submission
            *  
            */        
            $browser->visit('/')                    
                    ->type('name', 'my_name')
                    ->type('email', $email)
                    ->type('phone', '(123)-456-7899')
                    ->type('address', '123 Main st.')
                    ->type('zipCode', '12345')                    
                    ->click('#submitButton')
                    ->waitForText('File field is required!')
                    ->assertSee('File field is required!');

            /*
            *   
            *  Incorrect format email field submission
            *  
            */        
            $browser->visit('/')                    
                    ->type('name', 'my_name')
                    ->type('email', '1234sdf')
                    ->type('phone', '(123)-456-7899')
                    ->type('address', '123 Main st.')
                    ->type('zipCode', '12345')
                    ->attach('file', $filepath)
                    ->click('#submitButton')
                    ->waitForText('Please type valid email address!')
                    ->assertSee('Please type valid email address!');

                 /*
            *   
            *  Incorrect format phone field submission
            *  
            */        
            $browser->visit('/')                    
                    ->type('name', 'my_name')
                    ->type('email', '1234sdf')
                    ->type('phone', '1-234-56-78-99')
                    ->type('address', '123 Main st.')
                    ->type('zipCode', '12345')
                    ->attach('file', $filepath)
                    ->click('#submitButton')
                    ->waitForText('Please type valid email address!')
                    ->assertSee('Please type valid email address!');

              /*
            *   
            *   Incorrect uploaded file format test
            *  
            */
            $browser->visit('/')
                    ->type('name', 'my_name')
                    ->type('email', $email)
                    ->type('phone', '(123)-456-7899')
                    ->type('address', '123 Main st.')
                    ->type('zipCode', '12345')
                    ->attach('file', $wrongFormatFilePath)
                    ->click('#submitButton')
                    ->waitForText('Please select valid file! Supported formats: jpeg, png, gif, pdf, doc')
                    ->assertSee('Please select valid file! Supported formats: jpeg, png, gif, pdf, doc');
        });
//->waitForText('Record successfully created!' || 'The email has already been taken')
//->assertSee('Record successfully created!' || 'The email has already been taken');

    }
}
