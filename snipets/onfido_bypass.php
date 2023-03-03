<style>
    input {
        width: 500px;
    }
</style>


<table>
    <tr>
        <td colspan="10"><h3>1. Find customerId by email!</h3></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><input type="text" name="email" value=""></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <button id="get_customer_id_by_emai">get customer id by email</button>
        </td>
    </tr>
    <tr>
        <td colspan="10"><h3>2. Get queries to set ID check passed by customerId</h3></td>
    </tr>
    <tr>
        <td>CustomerId</td>
        <td><input type="text" name="customer_id" value="1111-1111-2222"></td>
    </tr>
    <tr>
        <td>DB prefix</td>
        <td><input type="text" name="db_prefix" value="prod_"></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <button id="get_quries">generate</button>
        </td>
    </tr>
</table>

<div id="place_for_customer_id"></div>


<div id="place_for_queries" style="position: absolute;min-width:95%;min-height:30px;">
    <button id="copy_queries_btn" style="position: absolute; left: 5px;cursor: pointer;background-color: lightgreen">copy</button>
    <div style="border: 1px solid black; padding: 5px"></div>
</div>


<div id="msg_place" style="position: fixed; right: 10px; top: 10px; display: block"></div>
<div id="msg" style="display: none;background-color: lightgreen; border: none; padding: 10px;margin: 5px;border-radius: 7px;min-width: 300px;"></div>


<script>

    let mysqlDate = new Date().toISOString().slice(0, 19).replace('T', ' ');

    console.log('init', mysqlDate);

    const queriesTogetCustomerId = `  <br><br>SELECT customer_id FROM core_api.customer_data_models where account->'$.email' = 'email_place';`;


    const queries = `
  <br><br>
        INSERT INTO prod_accounts.customer_identity_checks (\`id\`, \`customer_id\`, \`data\`, \`is_identity_accepted\`, \`created_at\`, \`updated_at\`, \`deleted_at\`)
    VALUES
        ('customer-uui',
        'customer-uui',
        '[]', 1, 'date-inp', 'date-inp', NULL);

    <br><br>

    INSERT INTO prod_mobile.onfidos (\`id\`, \`onfido_applicant_id\`, \`onfidoable_type\`, \`onfidoable_id\`, \`attempt\`, \`created_at\`, \`updated_at\`, \`deleted_at\`)
    VALUES
        ('customer-uui', 'customer-uui', 'MS_ACCOUNT_CUSTOMER', 'customer-uui',0, 'date-inp', 'date-inp', NULL);
        <br><br>


    INSERT INTO prod_mobile.onfido_applicants (\`id\`, \`remote_id\`, \`href\`, \`sandbox\`, \`first_name\`, \`last_name\`, \`email\`, \`dob\`, \`id_numbers\`, \`location\`, \`consents\`, \`created_at\`, \`updated_at\`, \`deleted_at\`)
    VALUES
        ('customer-uui','customer-uui', '/v3.4/applicants/9bf02521-cbf2-4f5b-92a6-5c5458c0cdf6', 1, 'Arturs', 'Divdesmitdivi', 'ao22@flynowpaylater.com', '0000-00-00', '[]', NULL, NULL, 'date-inp', 'date-inp', NULL);
        <br><br>


    INSERT INTO prod_mobile.onfido_checks (\`id\`, \`remote_id\`, \`onfido_applicant_id\`, \`href\`, \`applicant_provides_data\`, \`remote_applicant_id\`, \`status\`, \`tags\`, \`result\`, \`form_uri\`, \`redirect_uri\`, \`results_uri\`, \`report_ids\`, \`completeness_notification_sent\`, \`created_at\`, \`updated_at\`, \`deleted_at\`)
    VALUES
        ('customer-uui',
        'customer-uui',
        'customer-uui',
        '/v3.2/checks/3d7c4141-babc-45af-8642-41aed7aa5263', 0, '9bf02521-cbf2-4f5b-92a6-5c5458c0cdf6', 'complete', '[]', 'clear', NULL, NULL, 'https://dashboard.onfido.com/checks/3d7c4141-babc-45af-8642-41aed7aa5263', '[\"283d2603-44b4-482a-96eb-e08603b821c9\", \"a9357df3-5638-46a1-9011-7e5dd6e94215\", \"50b2e4af-a7e7-4b1d-849f-77df45955ef1\"]', 'date-inp', 'date-inp', 'date-inp', NULL);
        <br><br>

        UPDATE core_api.customer_data_models set validation = JSON_SET(\`validation\`, "$.identity_document_check", JSON_OBJECT("expired", null,"running", null, "accepted",true, "declined", null, "executed",true,"expired_at", null,"started_at",null,"accepted_at", "date-inp","declined_at",null)) where customer_id = 'customer-uui';
        <br><br>

        `;

    const buttonGetQueries = document.querySelector('#get_quries');
    const buttonGetCustomerIdByEmail = document.querySelector('#get_customer_id_by_emai');
    const buttonCopyQueriesButton = document.querySelector('#copy_queries_btn');

    buttonGetCustomerIdByEmail.addEventListener('click', function () {
        const email = document.querySelector('input[name="email"]').value.trim();

        if (!email) {
            pushMessage('Email is required!', true);
            return;
        }

        let newQueries = queriesTogetCustomerId;

        const regEx = new RegExp('email_place', "g");
        let sql = newQueries.replace(regEx, email);

        const target = document.querySelector('#place_for_queries > div');
        target.innerHTML = sql;

        pushMessage('SQL to find customerIs is generated!');
    });

    buttonGetQueries.addEventListener('click', function () {
        const newQueries = queries;

        const customerId = document.querySelector('input[name="customer_id"]').value;
        const dbPrefix = document.querySelector('input[name="db_prefix"]').value;

        if (!customerId) {
            pushMessage('CustomerID is required!', true);
            return;
        }

        const regEx = new RegExp('customer-uui', "g");
        let sql = newQueries.replace(regEx, customerId);

        const regEx0 = new RegExp('date-inp', "g");
        sql = sql.replace(regEx0, mysqlDate);

        if (dbPrefix) {
            console.log(dbPrefix);
            const regEx1 = new RegExp('prod_', "g");
            sql = sql.replace(regEx1, dbPrefix);

            const regEx2 = new RegExp('ms_', "g");
            sql = sql.replace(regEx2, dbPrefix);
        }

        const target = document.querySelector('#place_for_queries > div');
        target.innerHTML = sql;

        pushMessage('SQL inserts to set Onfido ID check passed is generated!');
    });

    buttonCopyQueriesButton.addEventListener('click', function () {
        let content = document.querySelector('#place_for_queries > div').innerHTML;

        if(!content){
            pushMessage('Nothing to copy', true);
            return;
        }

        content = content.replaceAll('<br>', '');
        content = content.replaceAll('&gt;', '>');

        navigator.clipboard.writeText(content);

        pushMessage('SQL(s) are added to clipboard!');
    })


    function pushMessage(message, isError = false) {

        let msg1 = document.querySelector('#msg');
        let msgPlace = document.querySelector('#msg_place');
        let msg = msg1.cloneNode();

        let id = 'T' + Math.floor(Math.random() * 1000000);

        msg.setAttribute('id', id);

        msg.innerHTML = message;

        if (isError) {
            msg.style.backgroundColor = 'red';
        }
        msg.style.display = 'block';


        msgPlace.append(msg);

        setTimeout(function () {
            const selector = '#' + id;
            msgPlace.querySelector(selector).remove();
        }, 3000);
    }
</script>