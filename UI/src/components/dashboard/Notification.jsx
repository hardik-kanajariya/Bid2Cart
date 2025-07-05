import React, {Component} from 'react'

export default class Notification extends Component {

    constructor(props) {
        super(props);
        this.state = {
            notification: null, purl: null,
        }
    }

    async componentDidMount() {

        let headersList = {
            "Accept": "application/json", "Authorization": "Bearer " + sessionStorage.getItem('token')
        }

        let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/notification`, {
            method: "GET", headers: headersList
        });

        let parsedNotification = await response.json();
        // console.log(parsedNotification)
        this.setState({notification: parsedNotification})
    }

    render() {
        let notification = null;
        if (this.state.notification != null) {
            // console.log(products.length);
            notification = this.state.notification.map(props => {
                return <div key={props.id}>
                    <div className="card m-2">
                        <div className="card-header">
                            <h3>{props.title}</h3>
                        </div>
                        <div className="card-body">
                            <p className='para' dangerouslySetInnerHTML={{__html: props.message}}></p>
                        </div>
                    </div>
                </div>
            })
        }
        return (<div className="tab-pane fade" id="v-pills-notification" role="tabpanel"
                     aria-labelledby="v-pills-notification-tab">
                {/* table title*/}
                <div className="table-title-area">
                    <h3>Notifications</h3>
                </div>
                {/* table */}
                <div className="row p-3">
                    {/* {product === null ? product : 'You have not win any bids try next time'} */}
                    {notification}
                </div>
            </div>)
    }
}