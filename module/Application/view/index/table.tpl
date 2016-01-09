<div id="nurse-schedule-back">
    <div class="nurse-schedule-overlay">
        <div class="container">
            <div class="row">
                    {foreach $nurses as $nurse}
                        <div class="col-lg-6 nurse-table">
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
                    {/foreach}
            </div>
        </div>
    </div>
</div>