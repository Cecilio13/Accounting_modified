<div class="header-menu">
    @include('inc.modal')
    <?php
set_time_limit(0);
    ?>
    <div class="col-sm-7">
        <div class="header-left">
            <button style="display:none;" class="search-trigger"><i class="fa fa-search"></i></button>
            <div class="form-inline">
                <form class="search-form">
                    <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                    <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-5">
        <div class="user-area dropdown float-right">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="user-avatar rounded-circle" src="{{asset('images/customers.png')}}" alt="User Avatar">
            </a>
            <div class="user-menu dropdown-menu">
                <a class="nav-link" href="#"><i class="far fa-user"></i> {{Auth::user()->name}}</a>
                <a class="nav-link" href="#" onclick="document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Sign Out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
            <div class="modal fade float-right" id="staticModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-backdrop="false">
                <div class="modal-dialog modal-sm float-right w-100" style="margin-top: 75px;" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticModalLabel">Feedback</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <textarea class="rounded w-100" rows="6" placeholder="Share your feedback or report a bug">
                            </textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info rounded">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>