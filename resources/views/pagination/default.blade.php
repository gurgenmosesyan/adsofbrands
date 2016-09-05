<?php
$link_limit = 6;

if ($pagination->lastPage() > 1) {
?>
<div id="paging">
    <ul class="fr">
        <li class="prev{{$pagination->currentPage() == 1 ? ' disabled' : ''}}">
            <a class="fb" href="{{$pagination->url($pagination->currentPage() - 1)}}"></a>
        </li>
        <?php
        for ($i = 1; $i <= $pagination->lastPage(); $i++) {
        $half_total_links = floor($link_limit / 2);
        $from = $pagination->currentPage() - $half_total_links;
        $to = $pagination->currentPage() + $half_total_links;
        if ($pagination->currentPage() < $half_total_links) {
            $to += $half_total_links - $pagination->currentPage();
        }
        if ($pagination->lastPage() - $pagination->currentPage() < $half_total_links) {
            $from -= $half_total_links - ($pagination->lastPage() - $pagination->currentPage()) - 1;
        }
        if ($from < $i && $i < $to) {
        ?>
        <li{!!$pagination->currentPage() == $i ? ' class="active"' : ''!!}>
        <a class="fb" href="{{$pagination->url($i)}}">{{$i}}</a>
        </li>
        <?php
        }
        }
        if ($pagination->lastPage() - $to > 1) {
        ?>
        <li><span class="fb dots">...</span></li>
        <li><a class="fb" href="{{$pagination->url($pagination->lastPage())}}">{{$pagination->lastPage()}}</a></li>
        <?php } ?>
        <li class="next{{$pagination->currentPage() == $pagination->lastPage() ? ' disabled' : ''}}">
            <a class="fb" href="{{$pagination->url($pagination->currentPage() + 1)}}"></a>
        </li>
    </ul>
    <div class="cb"></div>
</div>
<?php } ?>