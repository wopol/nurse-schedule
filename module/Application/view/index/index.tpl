
{foreach $nurses as $nurse}
    {$nurse->id()}:
    {foreach $nurse->shifts as $shift}
        {$shift->getDay()->getDayNumber()}{$shift->getType()} ,
    {/foreach}
    <br/>
    <br/>
{/foreach}
<br/>
