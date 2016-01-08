<script>
require(["dojo/parser", "dojo/ready", "dojox/calendar/Calendar", "dojo/store/Observable", "dojo/store/Memory"],
  function(parser, ready, Calendar, Observable, Memory){
    ready(function(){
        var someData = [
          {
            id: 0,
            summary: "Event 1",
            startTime: new Date(2012, 0, 1, 10, 0),
            endTime: new Date(2012, 0, 1, 12, 0)
          }
        ];

        calendar = new Calendar({
          date: new Date(2012, 0, 1),
          store: new Observable(new Memory({ data: someData })),
          dateInterval: "day",
          style: "position:relative;width:500px;height:500px"
      }, "nurseCalendar");
              }
    )}
  );

</script>
<div id="nurseCalendar"></div>
{*foreach $nurses as $nurse}
    {$nurse->id()}:
    {foreach $nurse->getShifts() as $shift}
        {$shift->getDateString()}
        {$shift->getType()}
        {if $shift->getDay()->isWeekend()}*{/if} ,<br/>
    {/foreach}
    <br/>
    <br/>
{/foreach*}
<br/>
