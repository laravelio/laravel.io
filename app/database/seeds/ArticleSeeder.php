<?php

use Lio\Articles\Article;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        if (Article::count() == 0) {
            $this->createArticles();
        }
    }

    private function createArticles()
    {
        $content =<<<EOF
<script src="http://www.buzzsprout.com/11908/113354-laravel-io-podcast-5-with-matthew-machuga-and-chris-fidao.js?player=small" type="text/javascript" charset="utf-8"></script>

## Intro / Outro music

Thanks to _druu for providing us with some intro / outro music. We'd really love for Laravel community members to submit some intro / outro music for the podcast as we find our voice. Thanks again, _druu!

## Request for Feedback
Hey everyone, we really enjoy making this podcast. But, we could really use some feedback. What is good to listen to and what isn't? Do you like the more casual conversational style that we've had lately? Please give us feedback in the comments so that we can have some direction.

## Referenced in this episode

[Chris Fidao's book, "Implementing
Laravel"](https://leanpub.com/implementinglaravel)

[Info about the PHP RFC for Named
Parameters](http://philsturgeon.co.uk/blog/2013/09/named-parameters-in-php)

[Practical Object-Oriented Design in Ruby](http://poodr.com/)

[Presentation: Therapeutic Refactoring by Katrina
Owen](http://www.youtube.com/watch?v=J4dlF0kcThQ)

[Presentation: Sandi Metz - Less - The Path to Better
Design](http://vimeo.com/26330100)

[Presentation: Growing a Language by Guy
Steele](http://www.youtube.com/watch?v=_ahvzDzKdB0)
EOF;

        $article = Article::create([
            'author_id'    => 1,
            'title'        => 'Podcast #5 with Matthew Machuga and Chris Fidao',
            'content'      => $content,
            'status'       => 1,
            'published_at' => '2013-09-07 20:10:41',
        ]);

        $article->tags = [19];

        $content =<<<EOF
I recently [replaced some Laravel functionality](https://github.com/robclancy/laravel4-hashing) for someone who was forced to use [Laravel 4](http://laravel.com) on a shared host which didn't have PHP up to date. I thought this would be a good time to explain one of the advantages of the component based architecture of Laravel 4 and how I was able to drop the PHP requirement to 5.3.2 in less than an hour.

Laravel 4 uses [Bcrypt](http://en.wikipedia.org/wiki/Bcrypt), [as it should](http://www.codinghorror.com/blog/2012/04/speed-hashing.html). More accurately, it uses [Anthony Ferrara's](https://twitter.com/ircmaxell) [password_compat](https://github.com/ircmaxell/password_compat#password_compat) library which brings PHP 5.5 [password functionality](https://wiki.php.net/rfc/password_hash) (of which he [designed](http://blog.ircmaxell.com/2012/11/designing-api-simplified-password.html) and proposed the specification for) to PHP 5.3.7+. Therefore the minimum PHP requirement for Laravel 4 is the same as password_compat. This is the only thing pushing the requirement past 5.3.2 so I just had to replace that functionality.

I am going to go step by step through how I made the package as an overview on creating packages for Laravel and to show you how little I needed to change for this to work.

When I start with any package I first create my repository on github and clone it. Then comes the generic directory structure I always use which is as follows.

    /src
        /Robbo
    /tests
    .gitignore
    .travis.yml
    README.md
    composer.json
    phpunit.xml

The root files here are generally the same except for composer.json. You can copy them from any of my packages if need be.

Now we need something to do the actual hashing, luckily Anthony has us covered there too with [PHP-PasswordLib](https://github.com/ircmaxell/PHP-PasswordLib#about). I just add it to composer.json under require with "PasswordLib/PasswordLib": "*". After which you will need to do a composer update. This is now ready to go, composer will handle the autoloading.

Next is the new implementation of Illuminate\Hashing\HasherInterface. I am going to be using the Sha512 Hash function, however the library will be expanded in future to support more of [the hash functions](https://github.com/ircmaxell/PHP-PasswordLib#specifications) provided by PHP-PasswordLib.

It starts off in src/Robbo/Hashing/Sha512Hasher.php as...

    <?php namespace Robbo\Hashing;

    use PasswordLib\PasswordLib;
    use Illuminate\Hashing\HasherInterface;

    class Sha512Hasher implements HasherInterface {

    }

Now we can just copy paste the contents from Illuminate\Hashing\HasherInterface.

    <?php namespace Robbo\Hashing;

    use PasswordLib\PasswordLib;
    use Illuminate\Hashing\HasherInterface;

    class Sha512Hasher implements HasherInterface {

        /**
         * Hash the given value.
         *
         * @param  string  Svalue
         * @return array   Soptions
         * @return string
         */
        public function make(Svalue, array Soptions = array());

        /**
         * Check the given plain value against a hash.
         *
         * @param  string  Svalue
         * @param  string  ShashedValue
         * @param  array   Soptions
         * @return bool
         */
        public function check(Svalue, ShashedValue, array Soptions = array());

        /**
         * Check if the given hash has been hashed using the given options.
         *
         * @param  string  ShashedValue
         * @param  array   Soptions
         * @return bool
         */
        public function needsRehash(ShashedValue, array Soptions = array());
    }

We need a PasswordLib instance now. So create it in the constructor for later use.

    <?php namespace Robbo\Hashing;

    use PasswordLib\PasswordLib;
    use Illuminate\Hashing\HasherInterface;

    class Sha512Hasher implements HasherInterface {

        protected Shasher;

        /**
         * Create a new Sha512 hasher instance.
         *
         * @return void
         */
        public function __construct()
        {
            Sthis->hasher = new PasswordLib;
        }

        /**
         * Hash the given value.
         *
         * @param  string  Svalue
         * @return array   Soptions
         * @return string
         */
        public function make(Svalue, array Soptions = array());

        /**
         * Check the given plain value against a hash.
         *
         * @param  string  Svalue
         * @param  string  ShashedValue
         * @param  array   Soptions
         * @return bool
         */
        public function check(Svalue, ShashedValue, array Soptions = array());

        /**
         * Check if the given hash has been hashed using the given options.
         *
         * @param  string  ShashedValue
         * @param  array   Soptions
         * @return bool
         */
        public function needsRehash(ShashedValue, array Soptions = array());

    }

Now all we need to do is fill out the methods and the hasher should work anywhere in Laravel without issue.

The make method will make a simple call to PasswordLib to create the Sha512 hash. It uses 'S6S' to identify as Sha512.

    /**
     * Hash the given value.
     *
     * @param  string  Svalue
     * @return array   Soptions
     * @return string
     */
    public function make(Svalue, array Soptions = array())
    {
        return Sthis->hasher->createPasswordHash(Svalue, 'S6S', Soptions);
    }

Then for the check method it is another single call to PasswordLib. It does all the heavy lifting making this a second very simple line of code.

    /**
     * Check the given plain value against a hash.
     *
     * @param  string  Svalue
     * @param  string  ShashedValue
     * @param  array   Soptions
     * @return bool
     */
    public function check(Svalue, ShashedValue, array Soptions = array())
    {
        return Sthis->hasher->verifyPasswordHash(Svalue, ShashedValue);
    }

Lastly, we aren't supporting rehashing so just return false for that method (I might support it in future if required). Here is the Hasher fully implemented.

    <?php namespace Robbo\Hashing;

    use PasswordLib\PasswordLib;
    use Illuminate\Hashing\HasherInterface;

    class Sha512Hasher implements HasherInterface {

        protected Shasher;

        /**
         * Create a new Sha512 hasher instance.
         *
         * @return void
         */
        public function __construct()
        {
            Sthis->hasher = new PasswordLib;
        }

        /**
         * Hash the given value.
         *
         * @param  string  Svalue
         * @return array   Soptions
         * @return string
         */
        public function make(Svalue, array Soptions = array())
        {
            return Sthis->hasher->createPasswordHash(Svalue, 'S6S', Soptions);
        }

        /**
         * Check the given plain value against a hash.
         *
         * @param  string  Svalue
         * @param  string  ShashedValue
         * @param  array   Soptions
         * @return bool
         */
        public function check(Svalue, ShashedValue, array Soptions = array())
        {
            return Sthis->hasher->verifyPasswordHash(Svalue, ShashedValue);
        }

        /**
         * Check if the given hash has been hashed using the given options.
         *
         * @param  string  ShashedValue
         * @param  array   Soptions
         * @return bool
         */
        public function needsRehash(ShashedValue, array Soptions = array())
        {
            return false;
        }

    }

Now we have our hasher implementation sorted. What's next? Well how do we know if it even works? Let's make a test. Create the test file at tests/Sha512HasherTest.php and test the 2 methods we are using.

    <?php

    class Sha512HasherTest extends PHPUnit_Framework_TestCase {

        public function testBasicHashing()
        {
            Shasher = new Robbo\Hashing\Sha512Hasher;
            Svalue = Shasher->make('password');
            Sthis->assertTrue(Svalue !== 'password');
            Sthis->assertTrue(Shasher->check('password', Svalue));
            Sthis->assertFalse(Shasher->check('wrongpassword', Svalue));
        }
    }

Lastly we need to tell laravel to use the new Hasher. For this situation I decided to just extend Illuminate\Hashing\HashServiceProvider to register the new Hasher. This class simply contains yet another single line method.

    <?php namespace Robbo\Hashing;

    use Illuminate\Hashing\HashServiceProvider as ServiceProvider;

    class HashServiceProvider extends ServiceProvider {

        /**
         * Register the service provider.
         *
         * @return void
         */
        public function register()
        {
            Sthis->app['hash'] = Sthis->app->share(function() { return new Sha512Hasher; });
        }
    }

To get this working from here you simply replace Illuminate\Hashing\HashServiceProvider with Robbo\Hashing\HashServiceProvider in app/config/app.php... that is it. So installation is 2 file edits. You add the dependency to composer.json and edit the service providers array in the app config.
EOF;

        $article = Article::create([
            'author_id'    => 1,
            'title'        => 'Laravel 4 - Easily Extended',
            'content'      => $content,
            'status'       => 1,
            'published_at' => '2013-07-23 13:28:15',
        ]);

        $article->tags = [4, 11];

        $content =<<<EOF
Today we're proud to announce 3 more speakers, completing our lineup. First of all, we've very happy to announce that Taylor Otwell, the creator of Laravel will be present and accounted for. Laracon just wouldn't be the same without him.

We're also very excited to announce that Fabien Potencier, the creator of the Symfony framework and a leader in the modern PHP movement will be speaking about the current state of PHP. His talk will cover standards, best-practices, interoperability and the core philosophies that have led our industry forward.

To round out our incredible line-up we have Ross Tuck, a protocol specialist. He will be teaching us about many aspects of the HTTP protocol that will give us more power to leverage in our web-applications

We couldn't be more excited about this lineup.

So, what do you do if you want to make it to Laracon EU in August but can't afford a ticket? No problem! SANIsoft has you covered.

SANIsoft is hosting a raffle and giving away free Laracon tickets. To sign up head over to [http://laracon.eu/2013/raffle.html](http://laracon.eu/2013/raffle.html) and drop your email into the hat. We'll be picking addresses at random and giving out free tickets!

If you're not hedging your bets on a free ticket, then be sure to [buy yours before they're sold out.](http://laracon.eu)
EOF;

        $article = Article::create([
            'author_id'    => 1,
            'title'        => 'All Laracon EU Speakers Announced! And a ticket raffle!',
            'content'      => $content,
            'status'       => 1,
            'published_at' => '2013-07-11 13:06:22',
        ]);

        $article->tags = [19];
    }
}
