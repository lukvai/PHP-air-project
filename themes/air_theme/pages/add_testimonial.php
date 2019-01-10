
<section id="two" class="wrapper style2 special">
				<div class="container">
					<header class="major">
						<h2>Klientų atsiliepimai</h2>
						<p>Klientai apie mūsų paslaugas</p>
					</header>
					<section class="profiles">
						<div class="row">
							<section class="3u 6u(medium) 12u$(xsmall) profile">
								<img src="themes/air_theme/images/profile_placeholder.gif" alt="" />
								<h4>Vardas</h4>
								<p>Atsiliepimo tekstas</p>
							</section>
							<section class="3u 6u$(medium) 12u$(xsmall) profile">
								<img src="themes/air_theme/images/profile_placeholder.gif" alt="" />
								<h4>Vardas</h4>
								<p>Atsiliepimo tekstas</p>
							</section>
							<section class="3u 6u(medium) 12u$(xsmall) profile">
								<img src="themes/air_theme/images/profile_placeholder.gif" alt="" />
								<h4>Vardas</h4>
								<p>Atsiliepimo tekstas</p>
							</section>
							<section class="3u$ 6u$(medium) 12u$(xsmall) profile">
								<img src="themes/air_theme/images/profile_placeholder.gif" alt="" />
								<h4>Vardas</h4>
								<p>Atsiliepimo tekstas</p>
							</section>
						</div>
					</section>
					<footer>
						<p>Palikite mums atsiliepimą</p>
						<ul class="actions">
							<li>
								<a class="button big fb">Rašyti</a>
							</li>
						</ul>
					</footer>
				</div>
			</section>

<section id="three" class="wrapper style3 special">
				<div class="container">
					<header class="major">
						<h2>Turite problemą? Rašykite mums</h2>
						<p>Esame pasiruošę Jums padėti</p>
					</header>
				</div>
				<div class="container 50%">
					<form action="#" method="post">
						<div class="row uniform">
							<div class="6u 12u$(small)">
								<input name="name" id="name" value="" placeholder="Vardas" type="text">
							</div>
							<div class="6u$ 12u$(small)">
								<input name="email" id="email" value="" placeholder="El. paštas" type="email" required>
							</div>
							<div class="12u$">
								<textarea name="message" id="message" placeholder="Žinutė" rows="6"></textarea>
							</div>
							<div class="12u$">
								<ul class="actions">
									<li><input value="Siųsti" class="special big" type="submit" name="send"></li>
								</ul>
							</div>
						</div>
					</form>
				</div>
			</section>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        $('.fb').on('click', function() {
            $('#dialog').dialog({width: 'auto'});
        });
    });
</script>


<div id="dialog" title="Give us Feedback" style="display: none">
    <form action="#" method="post">
    <div class="row uniform">
        <div class="6u 12u$(small)">
            <input name="name" id="name" value="" placeholder="Vardas" type="text">
        </div>
        <div class="6u$ 12u$(small)">
            <input name="email" id="email" value="" placeholder="El. paštas" type="email" required>
        </div>
        <div class="12u$">
            <textarea name="message" id="message" placeholder="Žinutė" rows="6"></textarea>
        </div>
        <div class="12u$">
            <ul class="actions">
                <li><input value="Siųsti" class="special big" id="SendFb" type="submit" name="feedback"></li>
            </ul>
        </div>
    </div>
    </form>
</div>
