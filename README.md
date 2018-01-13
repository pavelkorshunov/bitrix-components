<p># BitrixComponents</p>
<p># Author: Pavel Korshunov</p>

<p>Простой Битрикс компонент, для удобного добавления формы обратной связи на странице, со сплывающим окном или без него.<br/>
За основу можно взять почтовый шоблон №7, добавив в тип почтового шаблона дополнительные поля при необходимости:</p>

<ul>
<li>#PHONE#</li>
<li>#PAGE_URL#</li>
</ul>

<p>Позволяет прикреплять файлы к письму и отправлять основные поля, стандартных форм обратной связи.<br/>
Примерный формат письма:</p>

<hr/>
<p>Информационное сообщение сайта #SITE_NAME#</p>
------------------------------------------

<p>Вам было отправлено сообщение через форму обратной связи</p>

<p>Автор: #AUTHOR#<br/>
E-mail автора: #AUTHOR_EMAIL#<br/>
Телефон: #PHONE#<br/>
Url страницы: #PAGE_URL#</p>

<p>Текст сообщения:<br/>
#TEXT#</p>

<p>Сообщение сгенерировано автоматически.</p>