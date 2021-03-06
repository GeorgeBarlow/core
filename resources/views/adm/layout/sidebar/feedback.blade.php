@can('use-permission', "adm/mship/feedback")
    <li class="treeview {{ ((\Request::is('adm/mship/feedback*')) ? 'active' : '') }}">
        <a href="#">
            <i class="ion ion-help"></i> <span>Member Feedback</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">

            @can('use-permission', "adm/mship/feedback/list/*")
                <li {!! (\Request::is('adm/mship/feedback/list') ? ' class="active"' : '') !!}>
                    <a href="{{ URL::route("adm.mship.feedback.all") }}">
                        <i class="fa fa-bars"></i>
                        <span>All Feedback</span>
                    </a>
                </li>
            @endcan

            <li class="treeview {{ Request::is('adm/mship/feedback/list*') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-bars"></i>
                    <span>Feedback Forms</span>
                    <i class="fa fa-angle-left"></i>
                </a>
                <ul class="treeview-menu">

                    @foreach($_feedbackForms as $f)

                        @can('use-permission', "adm/mship/feedback/list/".$f->slug)
                            <li {!! (\Request::is('adm/mship/feedback/list/'.$f->slug) ? ' class="active"' : '') !!}>
                                <a href="{{ URL::route("adm.mship.feedback.form", [$f->slug]) }}">
                                    <i class="fa fa-bars"></i>
                                    <span>{!! $f->name !!}</span>
                                </a>
                            </li>
                        @endcan

                    @endforeach

                </ul>
            </li>

            <li {!! ((\Request::is('adm/mship/feedback/configure*') || \Request::is('adm/mship/feedback')) ? ' class="active"' : '') !!}>
                <a href="{{ URL::route("adm.mship.feedback.forms") }}">
                    <i class="fa fa-cog"></i>
                    <span>Configure Forms</span>
                </a>
            </li>
        </ul>
    </li>
@endcan