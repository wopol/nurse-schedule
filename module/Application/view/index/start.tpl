<style type="text/css">
  .dojoxCalendar{ font-size: 12px; font-family:Myriad,Helvetica,Tahoma,Arial,clean,sans-serif; }
</style>

<script>
require(["dojo/parser", "dojo/ready", "dojox/calendar/Calendar", "dojo/store/Observable", "dojo/store/Memory", "dojox/calendar/ColumnView",
        'dojox/calendar/HorizontalRenderer',
        'dojox/calendar/LabelRenderer',
        'dojox/calendar/VerticalRenderer'],
  function(parser, ready, Calendar, Observable, Memory, ColumnView, HorizontalRenderer, LabelRenderer, VerticalRenderer){
    ready(function(){
        var someData = [
            {$counter=0}
            {foreach $nurses as $nurse}
                {foreach $nurse->getShifts() as $shift}
                    {
                      id: {$counter++},
                      summary: "{$shift->getType()}",
                      startTime: new Date('{$shift->getDateString()}'),
                      endTime: new Date('{$shift->getDateEndString()}')
                  },
                {/foreach}
                {if $counter > 100}
                    {break}
                {/if}
            {/foreach}
        ];

console.log(someData);


        calendar = new Calendar({
          date: new Date(2015, 9, 10),
          store: new Observable(new Memory({ data: someData })),
          dateInterval: "day",
          columnViewProps: {
     startTimeOfDay: {
         hours: 8,
         minutes: 0
     },
     minHours: 0,
     maxHours: 24,
     hourSize: 20,
     horizontalRenderer: HorizontalRenderer,
     verticalRenderer: VerticalRenderer
 },
          style: "position:relative;width:90%;height:800px"
      }, "nurseCalendar");
              }
    )}
  );

</script>
{foreach $nurses as $nurse}
    <div id="nurseCalendar"></div>
    {break}
{/foreach}

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
