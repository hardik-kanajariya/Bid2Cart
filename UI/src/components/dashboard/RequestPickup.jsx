import React, {useEffect, useState} from 'react'

export default function RequestPickup(props) {
    const [invoice, setInvoice] = useState([]);
    const [isLoaded, setIsLoaded] = useState(false);

    useEffect(() => {
        getInvoice().then(r => setIsLoaded(true));
    }, [props])

    async function getInvoice() {
        let headersList = {
            "Accept": "application/json",
            "Authorization": "Bearer " + sessionStorage.getItem('token')
        }

        let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/get-invoice`, {
            method: "GET",
            headers: headersList
        });
        let data = await response.json();
        // console.log(data)
        setInvoice(data);
    }

    // function to detect is object is empty or not 
    function isEmptyObject(obj) {
        return JSON.stringify(obj) === '[]';
    }

    return (
        <div className="tab-pane fade" id="v-pills-pickup" role="tabpanel" aria-labelledby="v-pills-pickup-tab">
            {/* table title*/}
            <div className="table-title-area">
                <h3>My Winning Products</h3>
            </div>
            {/* table */}
            <div className="row p-3 card">
                <table className="table table-active table-striped table-hover rounded w-100">
                    <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Invoice Number</th>
                        <th>Due Amount</th>
                        <th>Acknowledgement</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    {!isEmptyObject(invoice) ? invoice.map((props) => {
                        return (<>
                            <tr key={props.id}>
                                <td>{props.product_name}</td>
                                <td>{props.invoice_number}</td>
                                <td>{props.winning_amount}</td>
                                <td>{props.acknowledgement}</td>
                                <td>
                                    <a href={`${process.env.NEXT_PUBLIC_API_URL}/invoice/` + props.pdf}
                                       className='btn btn-primary'>Download Invoice</a>
                                </td>
                            </tr>
                        </>)
                    }) : (
                        <>
                            <h2>No Invoice Found</h2>
                        </>)}

                    </tbody>
                </table>
            </div>
        </div>
    )
}
