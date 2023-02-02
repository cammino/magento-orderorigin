## Instalação

git submodule add git@github.com:cammino/magento-orderorigin.git app/code/community/Cammino/Orderorigin
cp app/code/community/Cammino/Orderorigin/Cammino_Orderorigin.xml app/etc/modules/Cammino_Orderorigin.xml
cp app/code/community/Cammino/Orderorigin/202301260923-Add-origin-to-order-grid.patch 202301260923-Add-origin-to-order-grid.patch
git apply 202301260923-Add-origin-to-order-grid.patch
rm 202301260923-Add-origin-to-order-grid.patch

Verificar se o patch foi aplicado com sucesso, caso tenha acontecido algum erro, ver o conteúdo do patch e aplicar as alterações manualmente.

## Como usar

Inserir na url de entrada na loja os parâmetros de url gclid, utm_source, utm_medium e utm_campaign.
EX: https://lojademo.cammino.com.br/?gclid=AbCD123efG&utm_source=summer-mailer&utm_medium=email&utm_campaign=summer-sale

Quando um pedido for finalizado, ele irá persistir essas variáveis seguindo as seguintes regras:
Se GET['utm_source'], GET['utm_campaign'] e GET['utm_medium'] não sejam vazios, salvar eles.
Se gclid for diferente de vazio, salvar "Google Ads" em utm_source
Se HTTP_REFERER for vazio, salvar "Direct" em utm_source
Se HTTP_REFERER conter google.com, gclid for vazio e utms vazios, salvar "Google"
Caso contrário, salvar o valor do campo HTTP_REFERER