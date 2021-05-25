<style>
#jcarousel-procedure1 ul li:hover {
    background-color: rgba(115, 103, 240, .12);
}
#jcarousel-procedure2 ul li:hover {
    background-color: rgba(115, 103, 240, .12);
}
</style>
<!-- begin::carousel line 1-->
<div class="jcarousel-wrapper p-1">
    <div id="jcarousel-procedure1" class="jcarousel">
        <ul>
            <!-- row one -->
            @if(count($procedures_row_one)>0)
            @foreach($procedures_row_one as $p)
            <li style="cursor:pointer;" class="text-center" onClick="_formProcedureServiceItem(0,{{$p->number}})">
                <a style="cursor:pointer;">
                    <img style="max-height:150px;" src="{{ asset($p->image) }}" alt="" class="img-fluid">
                    <p class="text-center">{{$p->number}}</p>
                </a>
            </li>
            @endforeach
            @endif
        </ul>
    </div>
    <a href="#" class="jcarousel-control-prev">&lsaquo;</a>
    <a href="#" class="jcarousel-control-next">&rsaquo;</a>
    <p class="jcarousel-pagination d-none"></p>
</div>
<!-- end::carousel line 1 -->

<!-- begin::carousel line 2-->
<div class="jcarousel-wrapper p-1">
    <div id="jcarousel-procedure2" class="jcarousel">
        <ul>
            @if(count($procedures_row_two)>0)
            @foreach($procedures_row_two as $p)
            <li style="cursor:pointer;" class="text-center" onClick="_formProcedureServiceItem(0,{{$p->number}})">
                <a style="cursor:pointer;">
                    <p class="text-center">{{$p->number}}</p>
                    <img style="max-height:150px;" src="{{ asset($p->image) }}" alt="" class="img-fluid">
                </a>
            </li>
            @endforeach
            @endif
        </ul>
    </div>
    <a href="#" class="jcarousel-control-prev">&lsaquo;</a>
    <a href="#" class="jcarousel-control-next">&rsaquo;</a>
    <p class="jcarousel-pagination d-none"></p>
</div>
<!-- end::carousel line 2 -->

<script>
(function($) {
    $(function() {
        var jcarousel = $('#jcarousel-procedure1,#jcarousel-procedure2');

        jcarousel
            .on('jcarousel:reload jcarousel:create', function() {
                var carousel = $(this),
                    width = carousel.innerWidth();
                if (width >= 900) {
                    width = width / 10;
                }else if (width >= 600) {
                    width = width / 8;
                } else if (width >= 350) {
                    width = width / 2;
                }

                carousel.jcarousel('items').css('width', Math.ceil(width) + 'px');
            })
            .jcarousel({
                wrap: 'circular'
            });

        $('.jcarousel-control-prev')
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-control-next')
            .jcarouselControl({
                target: '+=1'
            });

        $('.jcarousel-pagination')
            .on('jcarouselpagination:active', 'a', function() {
                $(this).addClass('active');
            })
            .on('jcarouselpagination:inactive', 'a', function() {
                $(this).removeClass('active');
            })
            .on('click', function(e) {
                e.preventDefault();
            })
            .jcarouselPagination({
                perPage: 1,
                item: function(page) {
                    return '<a href="#' + page + '">' + page + '</a>';
                }
            });
    });
})(jQuery);
</script>