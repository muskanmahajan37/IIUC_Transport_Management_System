@extends('layouts.app')
@section('content')

    <header id="home" class="masthead">
        <div class="container">
            <div class="intro-text">
                <div class="intro-lead-in" style="padding:10px 0px;">Welcome To IIUC Transport Website!</div>
                <div class="intro-heading text-uppercase">It's Nice To Meet You</div>
                <div class="nextBus">
                    <div class="nextBus-info">
                        <table class="table table-responsive-lg">
                            <thead>
                            <tr>
                                <td colspan="4">
                                    <div class="nextBus-title">
                                        NEXT BUS<br>
                                        <hr>
                                        ( Day : <i> {!! $today !!} </i>, Time: {!! $now !!} )
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>Station From</td>
                                <td>Station To</td>
                                <td>Time</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="4">
                                    <div class="nextBus-title" style="text-align: left;">
                                        <i>MALE</i>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{!! $fromRouteM !!}</td>
                                <td>{{"IIUC CAMPUS"}}</td>
                                <td>{{$toIIUCMale}}</td>
                            </tr>

                            <tr>
                                <td>{{"IIUC CAMPUS"}}</td>
                                <td>{{$toRouteM}}</td>
                                <td>{{$toCityMale}}</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div class="nextBus-title" style="text-align: left;">
                                        <i>FEMALE</i>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{$fromRouteF}}</td>
                                <td>{{"IIUC CAMPUS"}}</td>
                                <td>{{$toIIUCFemale}}</td>
                            </tr>

                            <tr>
                                <td>{{"IIUC CAMPUS"}}</td>
                                <td>{{$toRouteF}}</td>
                                <td>{{$toCityFemale}}</td>
                            </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Todays Bus Schedule -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 id="schedule" class="section-heading text-uppercase">Today's Bus Schedule</h2>
                    <h3 class="section-subheading text-muted">Here is '{!! $day->dayname !!}' bus schedule</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="timeline">
                        <?php $sl = 0;?>
                        @foreach($times as $time)
                            <?php $schedules = App\Schedule::where('day', $day->id)
                                ->where('time', $time->id)
                                ->first();?>
                            @if($schedules)
                                {{--@foreach($schedules as $schedule)--}}
                                <li class="{!! ($sl+=1)%2 == 0? "timeline-inverted":""!!}">
                                    <div class="timeline-image">
                                        <h4>{{\Carbon\Carbon::parse(App\Time::where('id',$time->id)->first()->time)->format('g:i A')}}
                                            <br>
                                            {{--Gender--}}

                                            <?php $male = App\Schedule::where('day', $day->id)
                                                ->where('time', $time->id)
                                                ->where('male', '1')
                                                ->get();
                                            $female = App\Schedule::where('day', $day->id)
                                                ->where('time', $time->id)
                                                ->where('Female', '1')
                                                ->get();?>

                                            {{count($male)? 'Male':''}}
                                            @if(count($male) && count($female))
                                                {!! "<br>" !!}
                                            @endif
                                            {{count($female)? 'Female':''}}
                                        </h4>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            {{--Direction--}}
                                            Destination:
                                            <h4>
                                                <?php $toiiuc = App\Schedule::where('day', $day->id)
                                                    ->where('time', $time->id)
                                                    ->where('toiiuc', '1')
                                                    ->get();
                                                $fromiiuc = App\Schedule::where('day', $day->id)
                                                    ->where('time', $time->id)
                                                    ->where('fromiiuc', '1')
                                                    ->get();?>
                                                {{count($toiiuc)? 'To IIUC Campus':''}}
                                                @if(count($toiiuc) && count($fromiiuc))
                                                    {{","}}
                                                @endif
                                                {{count($fromiiuc)? 'From IIUC Campus':''}}
                                            </h4>
                                            Routes:
                                            <h4 class="subheading">

                                                {{--Routes--}}
                                                <?php $routes = App\Schedule::where('day', $day->id)
                                                    ->where('time', $time->id)
                                                    ->get();
                                                if (count($routes) > 1) {
                                                    $routeFlag = count($routes) - 1;
                                                } else {
                                                    $routeFlag = 0;
                                                }?>
                                                @foreach($routes as $route)
                                                    {{\App\BusRoute::where('id',$route->route)->first()->routename}}
                                                    @if($routeFlag)
                                                        {{", "}}
                                                    @endif
                                                    <?php $routeFlag -= 1;?>
                                                @endforeach
                                            </h4>
                                        </div>
                                        <div class="timeline-body">
                                            {{--<p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt--}}
                                            {{--ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam,--}}
                                            {{--recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium--}}
                                            {{--consectetur!</p>--}}
                                        </div>
                                    </div>
                                </li>
                                {{--@endforeach--}}
                            @endif
                        @endforeach

                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                <h4>Have a
                                    <br>
                                    Safe
                                    <br>
                                    Journey
                                </h4>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


    <!-- Notice Board -->

    <section class="bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 id="notice" class="section-heading text-uppercase">{{$noticetitle}}</h2>
                    <h3 class="section-subheading text-muted">{{$description}}</h3>
                </div>
            </div>

            <div class="row">
                @if(count($notices) > 0)
                    <?php $count = 0; ?>
                    @foreach($notices as $notice)
                        <?php $count = $count + 1; ?>
                        {{--@if($count<=12)--}}
                        <div class="col-md-3 col-md-3 portfolio-item">
                            <a class="portfolio-link" data-toggle="modal" href="#portfolioModal{{$count}}">
                                <div class="portfolio-hover">
                                    <div class="portfolio-hover-content">
                                        <i class="fa fa-plus fa-3x"></i>
                                    </div>
                                </div>
                                <img class="img-fluid" src="/storage/cover_images/{{$notice->cover_image}}"
                                     alt="{{$notice->title}}"> </a>
                            <div class="portfolio-caption">
                                <h4>{{$notice->title}}</h4>
                                <small>
                                    <p class="text-muted">
                                        Posted By:
                                        <i>
                                            {{DB::table('admin_users')->where('id', $notice->user_id)->first()->name}}
                                        </i><br>
                                        Posted At: {{$notice->created_at}}
                                    </p>
                                </small>
                            </div>
                        </div>

                        {{--@else--}}
                        {{--@break--}}
                        {{--@endif--}}
                    @endforeach
                @else
                    <h4>No notices found</h4>
                @endif

            </div>
            {{$notices->links()}}
        </div>
    </section>


    <!-- Emergency Contact -->

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 id="services" class="section-heading text-uppercase">Emergency Contact</h2>
                    <h3 class="section-subheading text-muted">Feel Free To Contact With Us</h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
              <i class="fa fa-circle fa-stack-2x text-primary"></i>
              <i class="fa fa-headphones fa-stack-1x fa-inverse"></i>
            </span>
                    <h4 class="service-heading">Md. Iqbal</h4>
                    <p class="text-muted"><i class="fa fa-mobile"></i> +8801824979830</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
              <i class="fa fa-circle fa-stack-2x text-primary"></i>
              <i class="fa fa-headphones fa-stack-1x fa-inverse"></i>
            </span>
                    <h4 class="service-heading">Md. Habib</h4>
                    <p class="text-muted"><i class="fa fa-mobile"></i> +8801843471983</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
              <i class="fa fa-circle fa-stack-2x text-primary"></i>
              <i class="fa fa-headphones fa-stack-1x fa-inverse"></i>
            </span>
                    <h4 class="service-heading">Md. Shabuj</h4>
                    <p class="text-muted"><i class="fa fa-mobile"></i> +8801861642510</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Team -->



    <section class="bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 id="about" class="section-heading text-uppercase">Developed By</h2>
                    <!-- <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3> -->
                </div>
            </div>

            <div class="col-sm-6">
                <div class="team-member">
                    <img class="mx-auto rounded-circle" src="/storage/img/team/1.jpg" alt="Towfiqul Islam">
                    <h4>Towfiqul Islam</h4><span>Dept. of CSE, IIUC</span>
                    <p class="text-muted">Full-Stack Developer</p>
                    <ul class="list-inline social-buttons">
                        <li class="list-inline-item">
                            <a href="http://twitter.com/TowfiqIslam">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="http://github.com/laziestcoder">
                                <i class="fa fa-github"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="http://facebook.com/towfiq.106">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="http://www.linkedin.com/in/towfiq106/">
                                <i class="fa fa-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="team-member">
                    <img class="mx-auto rounded-circle" src="/storage/img/team/2.jpg" alt="Sina Ibn Amin">
                    <h4>Sina Ibn Amin </h4><span>Dept. of CSE, IIUC</span>
                    <p class="text-muted">UI/UX Designer</p>
                    <ul class="list-inline social-buttons">
                        <li class="list-inline-item">
                            <a href="http://twitter.com/TowfiqIslam">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="http://github.com/sinaibnamin">
                                <i class="fa fa-github"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="http://www.facebook.com/sinaibnamin">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="http://www.linkedin.com/in/towfiq106/">
                                <i class="fa fa-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <p class="large text-muted">
                    This project is developed to automate the transport management system and to reduce hassles
                    regarding transportation. This version is an early release and is being observed to
                    improve the facilities.<br>If you have any query, don't hesitate to contact:<br>
                    <b>info@itms.com || itms@gmail.com</b>
                </p>
            </div>
        </div>

    </section>


    <!-- Contact -->

    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading text-uppercase">Report A Problem</h2>
                    <h3 class="section-subheading text-muted">You can complain us through this message box</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form id="contactForm" name="sentMessage" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" id="name" type="text" placeholder="Your Name *" required
                                           data-validation-required-message="Please enter your name.">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" id="email" type="email" placeholder="Your Email *"
                                           required data-validation-required-message="Please enter your email address.">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" id="phone" type="tel" placeholder="Your Phone *"
                                           required data-validation-required-message="Please enter your phone number.">
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea class="form-control" id="message" placeholder="Your Message *" required
                                              data-validation-required-message="Please enter a message."></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center">
                                <div id="success"></div>
                                <button id="sendMessageButton" class="btn btn-primary btn-xl text-uppercase"
                                        type="submit">Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>



    <!-- Portfolio Modals -->

    <!-- Modal 1 -->
    @if(count($notices) > 0)
        <?php $count = 0; ?>
        @foreach($notices as $notice)
            <?php $count = $count + 1; ?>
            {{--@if($count<=12)--}}
            <div class="portfolio-modal modal fade" id="portfolioModal{{$count}}" tabindex="-1" role="dialog"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="close-modal" data-dismiss="modal">
                            <div class="lr">
                                <div class="rl"></div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8 mx-auto">
                                    <div class="modal-body">

                                        <!-- Project Details Go Here -->

                                        <h2 class="text-uppercase">{!! $notice->title !!}</h2>
                                        <p class="item-intro text-muted">Posted
                                            By: {!! DB::table('admin_users')->where('id', $notice->user_id)->first()->name !!}</p>
                                        <img class="img-fluid d-block mx-auto"
                                             src="/storage/cover_images/{!! $notice->cover_image !!}"
                                             alt="{!! $notice->title !!}">
                                        <div style="text-align:left;">
                                            {!! $notice->body !!}
                                        </div>
                                        <br><br>
                                        <ul class="list-inline" style="text-align:left;">
                                            <li>
                                                <small>
                                                    Date: {!! $notice->created_at !!}
                                                </small>
                                            </li>
                                            {{--<li>Client: Threads</li>--}}
                                            {{--<li>Category: Illustration</li>--}}
                                        </ul>
                                        <button class="btn btn-primary" data-dismiss="modal" type="button">
                                            <i class="fa fa-times"></i>
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--@else--}}
            {{--@break--}}
            {{--@endif--}}
        @endforeach
    @endif
@endsection

