<style>
    .dropdown-menu {
        font-size: 13px !important;
    }

    table > tbody > tr:hover {
        cursor: pointer;
    }
</style>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">List of tickets</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Reports</a>
    </div>

    <div class="row form-group">
        <div class="modal fade" id="ModalChamado" tabindex="-1" role="dialog" aria-labelledby="titleModalChamado" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="titleModalChamado">Ticket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Recipient:</label>
                                <input type="text" class="form-control" id="recipient-name">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Message:</label>
                                <textarea class="form-control" id="message-text"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="alert alert-info" style="display: none" id="msgProcessando">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <i class="fas fa-spinner fa-pulse"></i> Deletando registro, aguarde...
            </div>

            <div class="alert alert-danger" style="display: none" id="msgErro">
                <button type="button" class="close" data-dismiss="alert">×</button>
                Ocorreu um erro ao deletar chamado!
            </div>

            <div class="alert alert-success" style="display: none" id="msgSucesso">
                <button type="button" class="close" data-dismiss="alert">×</button>
                Chamado deletado com sucesso!
            </div>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="meus-chamados-tab" data-toggle="tab" href="#meus-chamados" role="tab" aria-controls="meus-chamados" aria-selected="true"><i class="fas fa-ticket-alt"></i> My tickets </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="todos-chamados-tab" data-toggle="tab" href="#todos-chamados" role="tab" aria-controls="todos-chamados" aria-selected="false"><i class="fas fa-ticket-alt"></i> All tickets</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="meus-chamados" role="tabpanel" aria-labelledby="meus-chamados-tab">
                    <div class="d-sm-flex align-items-center mt-4 mb-4"> <!--justify-content-between-->
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3" data-toggle="modal" data-target="#ModalChamado">
                            <i class="fas fa-plus-square fa-sm text-white-50"></i> New ticket
                        </a>
                    </div>

                    <div class="table">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-sm" id="tableMyTickets">
                                <thead>
                                    <tr>
                                        <th style="width: 20px !important">Id</th>
                                        <th>Inicio</th>
                                        <th>Cliente</th>
                                        <th>Descrição</th>
                                        <th>Andamento</th>
                                        <th>Prioridade</th>
                                        <th>Módulo</th>
                                        <th>Atendente</th>
                                    </tr>
                                </thead>
                                <thead class="filtros hidden-xs">
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody> </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade show" id="todos-chamados" role="tabpanel" aria-labelledby="todos-chamados-tab">
                    <div class="d-sm-flex align-items-center mt-4 mb-4"> <!--justify-content-between-->
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3" data-toggle="modal" data-target="#ModalChamado">
                            <i class="fas fa-plus-square fa-sm text-white-50" ></i> New ticket
                        </a>
                    </div>

                    <div class="table">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-sm" id="tableTickets">
                                <thead>
                                    <tr>
                                        <th style="width: 20px !important">Id</th>
                                        <th>Inicio</th>
                                        <th>Cliente</th>
                                        <th>Descrição</th>
                                        <th>Andamento</th>
                                        <th>Prioridade</th>
                                        <th>Módulo</th>
                                        <th>Atendente</th>
                                    </tr>
                                </thead>
                                <thead class="filtros hidden-xs">
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody> </tbody>
                            </table>
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
    loadTableTickets('tableMyTickets')
    loadTableTickets('tableTickets')
})

</script>
