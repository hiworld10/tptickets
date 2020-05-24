<?php require HEADER; ?>

<div>
    <table class="table bg-light-alpha text-center mt-5">
        <?php if(!empty($calendarArray)) { ?>
            <tbody>
            <?php foreach ($calendarArray as $value) { ?>
                <tr>       
                    <td><img src="<?= $value->getEvent()->getImage()->getPath() ?>" height="200" width="350"/></td>
                    <td>
                        <form id="getCalendar" action="<?=  FRONT_ROOT ."/home/get-calendar"?>"  method="POST">
                            <div class="mt-5">
                                <a href="javascript:document.forms.getCalendar.submit()"> <!-- para que mande el form desde el hipervinc -->
                                    <input type="hidden" name="id_calendar" value="<?=$value->getId();  ?>">
                                    <big><big><?= $value->getEvent()->getName(); ?></big></big><br>
                                    <big><?=$value->getDate(); ?></big>
                                </a>
                            </div>
                        </form>
                    </td>
            <?php } ?>
                    <td>
                        <form action="<?=FRONT_ROOT?>/home/search" method="POST">
                            <button name="search" value="<?= $value->getName(); ?>" id="boton1" type="submit" class="btn btn-block btn-lg btn-primary btn-sm mt-5">Ver mas</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        <?php  } ?>
    </table>
</div>

<?php require FOOTER; ?>