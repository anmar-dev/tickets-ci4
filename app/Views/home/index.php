<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Reports</a>
    </div>

    <div class="row form-group">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card form-group">
                        <div class="card-body">
                            <form id="ticketsFilter" class="form-inline">
                                <label for="selectMes" class="sr">Filter by: </label>
                                <div class="col-md-3 mx-sm-5 mb-2">
                                    <select class="form-control" name="selectMonth" id="selectMonth"
                                        style="width: 100%">
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mx-sm-3 mb-2">
                                    <select class="form-control" name="selectYear" id="selectYear" style="width: 100%">
                                        <option value="2020">2020</option>
                                        <option value="2019">2019</option>
                                        <option value="2018">2018</option>
                                        <option value="2017">2017</option>
                                        <option value="2016">2016</option>
                                        <option value="2015">2015</option>
                                        <option value="2014">2014</option>
                                        <option value="2013">2013</option>
                                        <option value="2012">2012</option>
                                        <option value="2011">2011</option>
                                        <option value="2010">2010</option>
                                    </select>
                                </div>

                                <button type="text" id="searchTicket" class="btn btn-primary mb-2 shadow-sm"><i
                                        class="fa fa-search"></i> Search</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-12 form-group">
                    <div id="chartLinha"></div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="col-xl-12 col-md-12 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Tickets
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalTickets"> 0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-ticket-alt fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-md-12 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Tickets in
                                    the Month</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalTicketsMonth">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-ticket-alt fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-md-12 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">My Tickets</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="myTickets">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-ticket-alt fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-md-12 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">My Open Tickets
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="openTickets">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-ticket-alt fa-2x text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('')?>/assets/js/pages/tickets.js?v=<?=JS_VERSION?>"></script>

<script>
$(document).ready(() => {

    checkOptionsFilter();
    loadTicket();

    $('#ticketsFilter').submit((e) => {
        e.preventDefault();

        loadTicket();
    })
});

function loadTicket() {
    const yearMonth = `${$('#selectMonth option:selected').val()}${$('#selectYear option:selected').val()}`

    loadChartTickets(yearMonth);
    loadCardTickets(yearMonth);
}

function checkOptionsFilter() {
    const dateNow = new Date();
    const year = dateNow.getFullYear();
    let month = dateNow.getMonth() + 1;

    if (month <= 9) {
        month = `0${month}`
    }

    $('#selectMonth').val(month)
    $('#selectYear').val(year)
}
</script>