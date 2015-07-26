<?php
namespace spec\Lio\Content;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ForeignLanguageSpamDetectorSpec extends ObjectBehavior
{
    private $foreignLanguage = <<<TEXT
【빠나나９넷】≪ВВanana9.NЕT≫일산오피⇔안산오피[광명오피]수원오피™【빠나나９넷】≪ВВanana9.NЕT≫일산오피⇔안산오피[광명오피]수원오피™【빠나나９넷】≪ВВanana9.NЕT≫일산오피⇔안산오피[광명오피]수원오피™【빠나나９넷】≪ВВanana9.NЕT≫일산오피⇔안산오피[광명오피]수원오피™【빠나나９넷】≪ВВanana9.NЕT≫일산오피⇔안산오피[광명오피]수원오피™【빠나나９넷】≪ВВanana9.NЕT≫일산오피⇔안산오피[광명오피]수원오피™【빠나나９넷】≪ВВanana9.NЕT≫일산오피⇔안산오피[광명오피]수원오피™【빠나나９넷】≪ВВanana9.NЕT≫일산오피⇔안산오피[광명오피]수원오피™【빠나나９넷】≪ВВanana9.NЕT≫일산오피⇔안산오피[광명오피]수원오피™【빠나나９넷】≪ВВanana9.NЕT≫일산오피⇔안산오피[광명오피]수원오피™
TEXT;

    private $validText = 'This piece of text should pass.

<?php
namespace Lio\\Http\\Requests;

class ModifyContinentRequest extends Request {

public function authorize()
 {
return true;
 }

public function rules()
 {
$id = $this->segment(2);

 return [
\'name\' => \'required|unique:continents,name,\' . $id ,
 ];
 }
}';

    function it_is_initializable()
    {
        $this->shouldHaveType('Lio\Content\ForeignLanguageSpamDetector');
        $this->shouldHaveType('Lio\Content\SpamDetector');
    }

    function it_can_detect_foreign_language_as_spam()
    {
        $this->detectsSpam($this->foreignLanguage)->shouldReturn(true);
    }

    function it_passes_when_valid_text_was_entered()
    {
        $this->detectsSpam($this->validText)->shouldReturn(false);
    }
}
