<? $_areaname = -1 ?>
<div style="text-align: right">
<?= $plugin->get_page_chooser() ?>
</div>
<table cellspacing="0" cellpadding="2" border="0" width="100%" class="forum">
    <? foreach ($areas as $area) :
        // echo '<tr><td colspan="5">', var_dump($area), '</td></tr>';
    if ($_areaname != $area['area_name']) : ?>

        <? if ($_areaname != -1) : ?>
    <!-- bottom border -->
    <tr>
            <td class="areaborder" colspan="7">
                <span class="corners-bottom"><span></span></span>
            </td>
    </tr>
    <tr>
            <td colspan="6">&nbsp;</td>
    </tr>
    <? endif; ?>

    <? $_areaname = $area['area_name']; ?>
    <tr>
        <td class="forum_header" colspan="3" align="left">
            <span class="corners-top"></span>
            <span class="heading"><?= strtoupper($area['area_name']) ?>&nbsp;</span>
        </td>

        <? if ($show_area_edit) : ?>
        <td class="forum_header" width="1%">
            <span class="no-corner"></span>
            <span class="heading">&nbsp;</span>
        </td>
        <? endif; ?>

        <td class="forum_header" width="1%">
            <span class="no-corner"></span>
            <span class="heading"><?= _("BEITR&Auml;GE") ?></span>
        </td>

        <td class="forum_header" width="30%" colspan="2">
            <span class="corners-top-right"></span>
            <span class="heading"><?= _("LETZTE ANTWORT") ?></span>
        </td>
    </tr>
    <? endif; ?>

    <tr>
        <td class="areaborder">&nbsp;</td>
        <td class="areaentry icon" width="1%" valign="top" align="center">
            <?= Assets::img('icons/16/black/forum.png') ?>
        </td>
        <td class="areaentry" valign="top">

        <? if ($edit_area == $area['topic_id']) : ?>
            <form action="<?= PluginEngine::getLink($plugin) ?>" method="post">
                <input type="text" name="posting_title" style="width: 99%" value="<?= $area['name_raw'] ?>"><br/>
                <textarea name="posting_data" class="add_toolbar" style="width: 99%" rows="7"><?= $area['description_raw'] ?></textarea><br/>
                <div class="buttons">
                    <input type="image" <?= makebutton('speichern', 'src') ?>>&nbsp;&nbsp;&nbsp;
                    <a href="<?= PluginEngine::getLink('ForumPPPlugin') ?>">
                        <?= makebutton('abbrechen') ?>
                    </a>
                </div>
                <input type="hidden" name="subcmd" value="do_edit_posting">
                <input type="hidden" name="posting_id" value="<?= $area['topic_id'] ?>">
            </form>
            <? else : ?>

            <a href="<?= PluginEngine::getLink($plugin, array('root_id' => $area['topic_id'])) ?>">
                <span class="areaname"><?= $area['name'] ?></span>
            </a><br/>
            <?= $area['description'] ?>
        <? endif; ?>

        </td>

        <? if ($show_area_edit) : ?>
        <td width="20" align="center" valign="top" class="areaentry2" style="padding-top : 8px">
            <a href="<?= PluginEngine::getLink($plugin, array('subcmd' => 'edit_area', 'area_id' => $area['topic_id']))?>#create_area">
                <?= Assets::img('icons/16/blue/edit.png') ?>
            </a>
        </td>
        <? endif; ?>

        <td width="40" align="center" valign="top" class="areaentry2" style="padding-top : 8px">
            <?= ($area['num_postings'] > 0) ? ($area['num_postings'] - 1) : 0 ?>
        </td>

        <td width="30%" align="left" valign="top" class="areaentry2">
            <? if (is_array($area['last_posting'])) : ?>
            <?= _("von") ?>
            <a href="<?= UrlHelper::getLink('about.php?username='. $area['last_posting']['username']) ?>">
                    <?= htmlReady($area['last_posting']['user_fullname']) ?>
            </a>
            <? $infotext = _("Direkt zum Beitrag...") ?>
            <a href="<?= PluginEngine::getLink($plugin, $area['last_posting']['link_params']) ?>#<?= $area['last_posting']['link_params']['jump_to'] ?>" alt="<?= $infotext ?>" title="<?= $infotext ?>">
                    <img src="<?= $plugin->picturepath ?>/goto_posting.png" alt="<?= $infotext ?>" title="<?= $infotext ?>">
            </a><br/>
            <?= _("am") ?> <?= strftime($plugin->time_format_string_short, (int)$area['last_posting']['date']) ?>
            <? else: ?>
            <?= _("von") ?>
            <a href="<?= UrlHelper::getLink('about.php?username='. get_username($area['owner_id'])) ?>">
                    <?= htmlReady($area['author']) ?>
            </a>
            <? endif; ?>
        </td>
        <td class="areaborder">&nbsp;</td>
    </tr>

  <? endforeach; ?>

    <!-- bottom border -->
    <tr>
        <td class="areaborder" colspan="7">
            <span class="corners-bottom"><span></span></span>
        </td>
    </tr>
</table>
<div style="text-align: right">
    <?= $plugin->get_page_chooser() ?>
</div>
<br>
<br>