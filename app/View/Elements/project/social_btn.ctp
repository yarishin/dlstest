<div class="social_btn social_btn_project">
    <table>
        <tr>
            <td class="tw">
                <a href="https://twitter.com/share" class="twitter-share-button"
                   data-url="<?php echo $this->Html->url(array(
                           'controller' => 'projects', 'action' => 'view', $project['Project']['id']
                   ), true) ?>"
                   data-text="<?php echo h($project['Project']['project_name']) ?> - <?php echo h($setting['site_name']) ?>"
                   data-lang="ja">ツイート</a>
                <script>!function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                        if (!d.getElementById(id)) {
                            js = d.createElement(s);
                            js.id = id;
                            js.src = p + '://platform.twitter.com/widgets.js';
                            fjs.parentNode.insertBefore(js, fjs);
                        }
                    }(document, 'script', 'twitter-wjs');</script>
            </td>
            <td class="fb" style="padding-left:10px;">
                <div class="fb-like" data-href="<?php echo $this->Html->url(array(
                        'controller' => 'projects', 'action' => 'view', $project['Project']['id']
                ), true) ?>"
                     data-send="false" data-layout="button_count" data-width="200" data-show-faces="true"
                     data-font="arial"></div>
            </td>
        </tr>
    </table>
</div>