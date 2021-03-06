<script src="//ajax.googleapis.com/ajax/libs/dojo/1.10.4/dojo/dojo.js" data-dojo-config="async: true"></script>
<style type="text/css">
  .dojoxCalendar{ font-size: 12px; font-family:Myriad,Helvetica,Tahoma,Arial,clean,sans-serif; }
</style>

<script>
require(["dojo/parser", "dojo/ready", "dojox/calendar/Calendar", "dojo/store/Observable", "dojo/store/Memory", "dojox/calendar/ColumnView",
        'dojox/calendar/HorizontalRenderer',
        'dojox/calendar/LabelRenderer',
        'dojox/calendar/VerticalRenderer',
        'dojo/dom',
        'dijit/registry',
        'dojo/dom-construct'],
  function(parser, ready, Calendar, Observable, Memory, ColumnView, HorizontalRenderer, LabelRenderer, VerticalRenderer, dom, registry, domConstruct){
     var schedule = JSON.parse('{$scheduleJson}');

    ready(function(){
        console.log(schedule);
    });

    changeNurse = function(nurseId) {

        if (registry.byId('nurseCalendar')) {
            registry.byId('nurseCalendar').destroyRecursive();
        }
        var container = domConstruct.toDom("<div id='nurseCalendar'></div>");
        domConstruct.place(container, "nurseCalendarContainer");
        domConstruct.destroy('nurse-schedule-hello');

        calendar = new Calendar({
            date: new Date({$year}, {$month-1}, {$day}),
            store: new Observable(new Memory({ data: schedule[nurseId].shifts })),
            dateInterval: "week",
            decodeDate: function(s) {
                    return new Date(s);
            },
            cssClassFunc: function(item){
                return item.calendar;
            },
            columnViewProps: {
                startTimeOfDay: {
                    hours: 8,
                    minutes: 0,
                    duration: 1000
                },
                minHours: 0,
                maxHours: 24,
                hourSize: 15,
                minColumnWidth: -1,
                horizontalRenderer: HorizontalRenderer,
                verticalRenderer: VerticalRenderer
            },
            style: "position:relative;width:100%;height:490px"
        }, "nurseCalendar");
    }
});
</script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        $("#show-tabled-btn").click(function(e) {
            if($(this).hasClass('active')) {
                $('#schedule-tabled').hide("slow");
                $(this).empty().html('Pokaż kalendarz w formie tabeli').removeClass('active');
            }
            else {
                $('#schedule-tabled').show("slow");
                $(this).empty().html('Ukryj kalendarz w formie tabeli').addClass('active');
            }
        });
    });
</script>
<div id="nurse-schedule-back">
    <div class="nurse-schedule-overlay">
        <div class="container">
            <div id="nurse-schedule-container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Gratulacje, nowy grafik został poprawnie wygenerowany!</h2>
                    </div>
                    <div class="col-lg-12">
                        <label for="nurse-select">Wybierz pielęgniarkę, której grafik chcesz zobaczyć:</label>
                        <select onchange="changeNurse(this.value);" class="form-control" name="nurse-select" id="nurse-select">
                            <option value="">Wybierz...</option>
                            {foreach $schedule as $nurse}
                                <option value="{$nurse['nurse']['nurse_id']}">Pielęgniarka {$nurse['nurse']['nurse_id']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="col-lg-12">
                        <h3 id="nurse-schedule-hello">Wybierz pielęgniarkę, aby wyświetlić grafik!</h3>
                    </div>
                    <div class="col-lg-12" id="show-tabled">
                        <button class="btn btn-primary" id="show-tabled-btn">Pokaż kalendarz w formie tabeli</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" id="nurseCalendarContainer">

                </div>
            </div>
            <div id="schedule-tabled">
                <div class="row">
                    {foreach $nurses as $nurse}
                        <div class="col-lg-6">
                            <div class="nurse-table">
                                <h3>Grafik dla pielęgniarki nr: {$nurse->id()}</h3>
                                <table class="table table-condensed table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Typ</th>
                                        <th>Weekend</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {foreach $nurse->getShifts() as $shift}
                                        <tr>
                                            <td>{$shift->getDateString()}</td>
                                            <td>{$shift->getType()}</td>
                                            <td>{if $shift->getDay()->isWeekend()}<strong>TAK</strong>{else}NIE{/if}</td>
                                        </tr>
                                    {/foreach}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
</div>
