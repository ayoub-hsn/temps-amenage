@extends('etudiant.layouts.master')
@section('content')
<style>
html, body {
    height: 100%;
}

.messagerie-container {
    display: flex;
    gap: 20px;
    height: calc(100vh - 50px); /* prend presque toute la hauteur de l'écran */
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Sidebar messages */
.messagerie-sidebar {
    width: 350px;
    background: #f7f9fc;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    overflow-y: auto;
    flex-shrink: 0;
    height: 100%; /* remplissage complet du parent */
}

/* Header */
.messagerie-sidebar h4 {
    font-weight: bold;
    margin-bottom: 15px;
    color: #004080;
    text-align: center;
}

/* Liste des messages */
.message-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.message-item {
    padding: 12px 15px;
    margin-bottom: 10px;
    background: #ffffff;
    border-radius: 10px;
    cursor: pointer;
    position: relative;
    transition: all 0.2s ease-in-out;
}

.message-item:hover {
    background: #e6f0ff;
}

.message-item.read {
    opacity: 0.7;
}

.message-item.unread::after {
    content: 'Nouveau';
    position: absolute;
    top: 12px;
    right: 12px;
    background: #ff4d4f;
    color: #fff;
    font-size: 10px;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 8px;
}

/* Info message */
.message-info h5 {
    margin: 0;
    font-size: 14px;
    font-weight: bold;
    color: #004080;
}

.message-info p {
    margin: 4px 0 0 0;
    font-size: 13px;
    color: #555;
}

.message-time {
    display: block;
    font-size: 11px;
    color: #999;
    margin-top: 5px;
}

/* Détail du message */
.messagerie-detail {
    flex: 1;
    background: #ffffff;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    overflow-y: auto;
    height: 100%; /* remplit toute la hauteur du parent */
}

.detail-message h5 {
    font-weight: bold;
    color: #004080;
    margin-bottom: 15px;
}

.detail-message p {
    font-size: 14px;
    color: #333;
    line-height: 1.5;
}

.detail-message .text-muted {
    font-size: 12px;
    color: #888;
    margin-top: 20px;
}

/* Scrollbar moderne */
.messagerie-sidebar::-webkit-scrollbar,
.messagerie-detail::-webkit-scrollbar {
    width: 8px;
}

.messagerie-sidebar::-webkit-scrollbar-thumb,
.messagerie-detail::-webkit-scrollbar-thumb {
    background-color: rgba(0, 64, 128, 0.6);
    border-radius: 4px;
}

.messagerie-sidebar::-webkit-scrollbar-track,
.messagerie-detail::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

/* Responsive */
@media(max-width: 992px){
    .messagerie-container {
        flex-direction: column;
        height: auto;
    }

    .messagerie-sidebar,
    .messagerie-detail {
        width: 100%;
        max-height: 400px;
    }
}

.no-message {
    display: flex;
    justify-content: center;
    align-items: center;
    height: calc(100% - 50px); /* soustrait la hauteur du header h4 */
    text-align: center;
    font-size: 14px;
    color: #777;
    padding: 20px;
}


</style>
  <div class="main-content">
    <section class="section">
      <div class="row ">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-statistic-4">
              <div class="align-items-center justify-content-between">
                <div class="row ">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15">Etablissements</h5>
                      <h2 class="mb-3 font-18">{{ $etablissementCount }}</h2>
                      <p class="mb-0" style="visibility: hidden;"><span class="col-green">0%</span> Increase</p>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                    <div class="banner-img">
                      <img style="max-width: 81%;" src="{{asset('dashboard/img/banner/university.png')}}" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-statistic-4">
              <div class="align-items-center justify-content-between">
                <div class="row ">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15">Filieres - Licence</h5>
                      <h2 class="mb-3 font-18">{{ $filierePasserelleCount }}</h2>
                      <p class="mb-0" style="visibility: hidden;"><span class="col-orange">0%</span> Decrease</p>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                    <div class="banner-img">
                      <img style="max-width: 81%;" src="{{asset('dashboard/img/banner/bachelor.png')}}" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-statistic-4">
              <div class="align-items-center justify-content-between">
                <div class="row ">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15">Filieres - Master</h5>
                      <h2 class="mb-3 font-18">{{ $filieresMasterCount }}</h2>
                      <p class="mb-0" style="visibility: hidden;"><span class="col-green">0%</span>
                        Increase</p>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                    <div class="banner-img">
                      <img style="max-width: 81%;" src="{{asset('dashboard/img/banner/master.png')}}" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-statistic-4">
              <div class="align-items-center justify-content-between">
                <div class="row ">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15">Mes candidatures</h5>
                      <h2 class="mb-3 font-18">{{ $candidaturesMasterCount + $candidaturesPasserelleCount }}</h2>
                      <p class="mb-0" style="visibility: hidden;"><span class="col-green">42%</span> Increase</p>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                    <div class="banner-img">
                      <img style="max-width: 81%;" src="{{asset('dashboard/img/banner/application.png')}}" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>



      <div class="messagerie-container">
        <!-- Sidebar -->
        <div class="messagerie-sidebar">
            <h4>Mes messages</h4>
            @if($allNotifications->count() > 0)
            <ul class="message-list">
                @foreach($allNotifications as $notif)
                <li class="message-item {{ $notif->read_at ? 'read' : 'unread' }}" data-id="{{ $notif->id }}">
                    <div class="message-info">
                        <h5>{{ Str::limit($notif->data['title'], 50) }}</h5>
                        <p>{{ Str::limit($notif->data['message'], 50) }}</p>
                    </div>
                    <span class="message-time">{{ $notif->created_at->diffForHumans() }}</span>
                    @if(!$notif->read_at)
                    <span class="badge-new">Nouveau</span>
                    @endif
                </li>
                @endforeach
            </ul>
            @else
            <div class="no-message">
                <p>Aucun message pour le moment.</p>
            </div>
            @endif
        </div>

        <!-- Detail panel -->
        <div class="messagerie-detail">
            <div id="detailMessage" class="detail-message">
                <p class="placeholder">Sélectionnez un message pour le lire</p>
            </div>
        </div>
    </div>











    </section>


  </div>

  <script>
    $(document).ready(function(){
        $('.message-item').on('click', function(){
            var id = $(this).data('id');
            var item = $(this);

            $.get('/etudiant/notifications/' + id, function(data){
                $('#detailMessage').html(`
                    <h5>${data.title}</h5>
                    <p>${data.message}</p>
                    <small class="text-muted">${data.time}</small>
                `);
                // Marquer comme lu visuellement
                item.removeClass('unread').addClass('read');
            });
        });
    });
    </script>




@endsection
