<?php
namespace spec\Lio\Backup;

use League\Flysystem\Filesystem;
use PhpSpec\ObjectBehavior;

class BackupManagerSpec extends ObjectBehavior
{
    function let(Filesystem $filesystem)
    {
        $this->beConstructedWith($filesystem);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lio\Backup\BackupManager');
    }

    function it_can_remove_old_backups(Filesystem $filesystem)
    {
        $files = ['foo.sql', 'foo1.sql', 'foo2.sql', 'foo3.sql', 'foo4.sql', 'foo5.sql', 'foo6.sql'];

        $filesystem->listFiles()->willReturn($files);
        $filesystem->getTimestamp('foo.sql')->willReturn(100);
        $filesystem->getTimestamp('foo1.sql')->willReturn(10000);
        $filesystem->getTimestamp('foo2.sql')->willReturn(100);
        $filesystem->getTimestamp('foo3.sql')->willReturn(100);
        $filesystem->getTimestamp('foo4.sql')->willReturn(500);
        $filesystem->getTimestamp('foo5.sql')->willReturn(100);
        $filesystem->getTimestamp('foo6.sql')->willReturn(100);
        $filesystem->delete('foo1.sql')->shouldBeCalled();
        $filesystem->delete('foo4.sql')->shouldBeCalled();

        $this->removeOldBackups(5)->willReturn(['foo1.sql', 'foo4.sql']);
    }
}
