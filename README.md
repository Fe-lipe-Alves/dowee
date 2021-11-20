Para realizar o login é necessário informar o email e senha de um usuário já cadastrado no sistema.

A tabela a seguir lista os possíveis retornos:

<table>
<thead>
    <tr>
        <td>Mensagem</td>
        <td>Status</td>
    </tr>
</thead>
<tbody>
    <tr>
        <td>Email ou senha inválido</td>
        <td>404</td>
    </tr>
    <tr>
        <td>Token expirado</td>
        <td rowspan="3">500</td>
    </tr>
    <tr>
        <td>Token inválido</td>
    </tr>
    <tr>
        <td>Token ausente</td>
    </tr>
    <tr>
        <td>Login efetuado</td>
        <td>200</td>
    </tr>
</tbody>
</table>


