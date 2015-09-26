<?php
namespace spec\Lio\Spam;

use Lio\Spam\PhoneNumberSpamDetector;
use Lio\Spam\SpamDetector;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PhoneNumberSpamDetectorSpec extends ObjectBehavior
{
    private $textWithPhoneNumbers = <<<TEXT
+91-8872522276 WORLD FAMOUS ASTROLOGER}...NAGESHEWAR BABA JI [DIAMOND
GOLD MEDLIST]....[+91-8872522276] Make one call and change your life
with in 21 hours call soon get solve your all problems with in 21 hours
that is 101% guaranteed We Provides Highly Effective Solutions For All
Problems Like
To Get Your Lost Love Back
To Attract Any Girl/Boy Towards You With Heart
To Make Agree 15+935=108Your Or Your Partner s Parents To Love Marriage
To Solve The Problems In Any Relationship
To Control The Mi1nd Of Husband/Wife Or A Desired Person
To Improve Professional And Personal Relationships With Others
To Wealth And Peace In Home
To Kundli And Match Making
To Manglik Dosh Niwaran
To Tell Your15 + 935 = 108 Future
To Control Of Others By Hypnotism
To Dosh Nivarana Like Manglik Dosh, Kalasarp Yoga
To Hawan/ Anusthan Etc.
To Get Your Lost Love Back By Vashikaran
To Get Your Lost Love Back By Black Magic
To Get High+919799138999          Income From Business
To Create A Good Impression On Others
To Create Love And Affection In Other s Heart And Mind
To Get Anything From True Astrology
To Get Your Ex Back By Hypnotism
To Get Your Lost Love
LOVE 91+7742228242 AFFARIS
HEART PIECE
BLACK MAGIC


919799138999
91 9799138999
91 - 9799138999
91 979 913 8999
91-979-913-8999
91+979+913+8999

+919799138999
+91 9799138999
+91 - 9799138999
+91 979 913 8999
+91-979-913-8999
+91+979+913+8999
+93
15+77=21

LOVE BACK +91 (3) 42228242
INTERCAST MARRIAGE
LOVE MARRIGES
CHILDREN NOT IN +91+7742228242FAVOUR ETC.
To Win Favors From Others
Get
Your Love Back By Vashikaran, Black Magic, Hypnotism, Get Your Love
Back By Vashikaran, Get Your Love Back By Vashikaran, Get Your Love Back
By Vashikaran, Help +91 - 8872522276 Me To Get My Love Back By Vashikaran, Kala Jadu,
Tantra Mantra, Tankarik Baba, Indian Astrologer
Just Give A Call & Get Your Love Back one call and change your life +91-8872522276 nageshewarbaba.blogspot.com email id nageshewarbaba@yahoo.com
TEXT;

    private $textWithoutPhoneNumbers = <<<TEXT
WORLD FAMOUS ASTROLOGER}...NAGESHEWAR BABA JI [DIAMOND
GOLD MEDLIST]....[] Make one call and change your life
with in 21 hours call soon get solve your all problems with in 21 hours
that is 101% guaranteed We Provides Highly Effective Solutions For All
Problems Like
To Get Your Lost Love Back
To Attract Any Girl/Boy Towards You With Heart
To Make Agree 15+935=108Your Or Your Partner s Parents To Love Marriage
To Solve The Problems In Any Relationship
To Control The Mi1nd Of Husband/Wife Or A Desired Person
To Improve Professional And Personal Relationships With Others
To Wealth And Peace In Home
To Kundli And Match Making
To Manglik Dosh Niwaran
To Tell Your15 + 935 = 108 Future
To Control Of Others By Hypnotism
To Dosh Nivarana Like Manglik Dosh, Kalasarp Yoga
To Hawan/ Anusthan Etc.
To Get Your Lost Love Back By Vashikaran
To Get Your Lost Love Back By Black Magic
To Get High         Income From Business
To Create A Good Impression On Others
To Create Love And Affection In Other s Heart And Mind
To Get Anything From True Astrology
To Get Your Ex Back By Hypnotism
To Get Your Lost Love
LOVE  AFFARIS
HEART PIECE
BLACK MAGIC


919799138999
91 9799138999
91 - 9799138999
91 979 913 8999
91-979-913-8999
91+979+913+8999

+91 979 913 8999
+91-979-913-8999
+91+979+913+8999
+93
15+77=21

LOVE BACK +91 (3) 42228242
INTERCAST MARRIAGE
LOVE MARRIGES
CHILDREN NOT IN  ETC.
To Win Favors From Others
Get
Your Love Back By Vashikaran, Black Magic, Hypnotism, Get Your Love
Back By Vashikaran, Get Your Love Back By Vashikaran, Get Your Love Back
By Vashikaran, Help Me To Get My Love Back By Vashikaran, Kala Jadu,
Tantra Mantra, Tankarik Baba, Indian Astrologer
Just Give A Call & Get Your Love Back one call and change your life nageshewarbaba.blogspot.com email id nageshewarbaba@yahoo.com
TEXT;

    private $otherTextWithPhoneNumber = 'ｂｅｓｔｔｔ~91-8872522276 vashikaran specialist uk usa india';

    function it_is_initializable()
    {
        $this->shouldHaveType(PhoneNumberSpamDetector::class);
        $this->shouldHaveType(SpamDetector::class);
    }

    function it_can_detect_phone_number_spam()
    {
        $this->detectsSpam($this->textWithPhoneNumbers)->shouldReturn(true);
        $this->detectsSpam($this->otherTextWithPhoneNumber)->shouldReturn(true);
    }

    function it_passes_when_no_phone_numbers_are_detected()
    {
        $this->detectsSpam($this->textWithoutPhoneNumbers)->shouldReturn(false);
    }
}
