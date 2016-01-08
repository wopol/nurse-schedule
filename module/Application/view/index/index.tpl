<div id="generate-schedule">
    <div class="container" id="overlay">
        <div class="row" id="main-container">
            <div class="col-lg-5"></div>
            <div class="col-lg-7" id="generate-form">
                <div class="row">
                <h3>Wprowadź parametry początkowe:</h3>
                <form action="/Application/Index/start" method="POST">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="nurse[36]">Ilość pielęgniarek (36h):</label>
                                <input type="number" class="form-control" id="nurse[36]" placeholder="">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="nurse[32]">Ilość pielęgniarek (32h):</label>
                                <input type="number" class="form-control" id="nurse[32]" placeholder="">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="nurse[20]">Ilość pielęgniarek (20h):</label>
                                <input type="number" class="form-control" id="nurse[20]" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="date[days]">Ilość dni do zaplanowania:</label>
                                <input type="number" class="form-control" id="date[days]" placeholder="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="date[startDate]">Data startu:</label>
                                <input type="date" class="form-control" id="date[startDate]" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="submit" class="btn btn-success" value="Generuj nowy grafik!">
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>