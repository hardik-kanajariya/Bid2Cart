import React, {useEffect, useState} from 'react'
import {toast} from "react-toastify";
import {ToastContainer} from 'react-toastify';

export default function ProfileTab() {
    const [user, setUser] = useState([]);
    const [firstName, setFirstName] = useState('')
    const [secondName, setSecondName] = useState('')
    const [mobile, setMobile] = useState('')
    const [street, setStreet] = useState('')
    const [city, setCity] = useState('')
    const [state, setState] = useState('')
    const [zipCode, setZipCode] = useState('')
    const [country, setCountry] = useState('')

    useEffect(() => {
        const getUserData = async () => {
            let headersList = {
                "Accept": "application/json", "Authorization": "Bearer " + sessionStorage.getItem('token')
            }

            let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/user`, {
                method: "GET", headers: headersList
            });
            let parsedData = await response.json();
            setUser(parsedData)

            // setting fields values
            setFirstName(parsedData.first_name)
            setSecondName(parsedData.last_name)
            setMobile(parsedData.phone)
            setStreet(parsedData.address)
            setCity(parsedData.city)
            setState(parsedData.state)
            setZipCode(parsedData.zip)
            setCountry(parsedData.country)
        }
        getUserData();
    }, [])

    const updateProfile = async (e) => {
        e.preventDefault();
        let headersList = {
            "Accept": "application/json",
            "Authorization": "Bearer " + sessionStorage.getItem('token'),
            "Content-Type": "application/json"
        }

        let bodyData = JSON.stringify({
            "firstName": firstName,
            "lastName": secondName,
            "mobile": mobile,
            "street": street,
            "city": city,
            "state": state,
            "zipcode": zipCode,
            "country": country
        });
        console.table(bodyData)
        if (confirm('Are you sure you want update your Profile?')) {
            let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/user/update`, {
                method: "POST", headers: headersList, body: bodyData
            });
            let data = await response.json();
            // console.log(data)
            if (data.status === 'true' || data.status === true) {
                toast.success('Profile Update successfully', {position: toast.POSITION.BOTTOM_RIGHT});
            } else {
                toast.error("Unable to update at this time please try again after some time", {position: toast.POSITION.BOTTOM_RIGHT});
            }
        } else {
            toast.warning("Profile update canceled by user", {position: toast.POSITION.BOTTOM_RIGHT});
        }
    }

    // Function to Mobile Number validation
    const validateMobile = (e) => {
        const re = /^[0-9\b]+$/;
        if (e.target.value === '' || re.test(e.target.value)) {
            if (e.target.value.length <= 10) {
                setMobile(e.target.value)
            }
        }
    }

    return (<div className="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
            <ToastContainer/>
            <div className="dashboard-profile">
                <div className="owner">
                    <div className="image">
                        <img alt="images"
                             src={user.avatar ? '' : "data:image/jpeg;base64,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"}/>
                    </div>
                    <div className="content">
                        <h3>{user.first_name}</h3>
                        <p className="para">{user.last_name}</p>
                    </div>
                </div>
                <div className="form-wrapper">
                    <form onSubmit={updateProfile}>
                        <div className="row">
                            <div className="col-xl-6 col-lg-12 col-md-6">
                                <div className="form-inner">
                                    <label>First Name *</label>
                                    <input type="text" placeholder={user.first_name} value={firstName}
                                           onChange={(e) => setFirstName(e.target.value)}/>
                                </div>
                            </div>
                            <div className="col-xl-6 col-lg-12 col-md-6">
                                <div className="form-inner">
                                    <label>Last Name *</label>
                                    <input type="text" placeholder={user.last_name} value={secondName}
                                           onChange={(e) => setSecondName(e.target.value)}/>
                                </div>
                            </div>
                            <div className="col-xl-6 col-lg-12 col-md-6">
                                <div className="form-inner">
                                    <label>Contact Number</label>
                                    <input type="text" placeholder={user.phone} value={mobile} onChange={(e) => {
                                        validateMobile(e);
                                    }}/>
                                </div>
                            </div>
                            <div className="col-xl-6 col-lg-12 col-md-6">
                                <div className="form-inner">
                                    <label>Email</label>
                                    <input type="text" placeholder={user.email} readOnly/>
                                </div>
                            </div>
                            <div className="col-12">
                                <div className="form-inner">
                                    <label>Street Address</label>

                                    <input type="text" placeholder={user.address} value={street}
                                           onChange={(e) => setStreet(e.target.value)}/>
                                </div>
                            </div>
                            <div className="col-xl-6 col-lg-12 col-md-6">
                                <div className="form-inner">
                                    <label>City</label>
                                    <input type="text" placeholder={user.city} value={city}
                                           onChange={(e) => setCity(e.target.value)}/>
                                </div>
                            </div>
                            <div className="col-xl-6 col-lg-12 col-md-6">
                                <div className="form-inner">
                                    <label>State</label>
                                    <input type="text" placeholder={user.state} value={state}
                                           onChange={(e) => setState(e.target.value)}/>
                                </div>
                            </div>
                            <div className="col-xl-6 col-lg-12 col-md-6">
                                <div className="form-inner">
                                    <label>Zip Code</label>
                                    <input type="text" placeholder={user.zip} value={zipCode}
                                           onChange={(e) => setZipCode(e.target.value)}/>
                                </div>
                            </div>
                            <div className="col-xl-6 col-lg-12 col-md-6">
                                <div className="form-inner">
                                    <label>Country</label>
                                    <input type="text" placeholder={user.country} value={country}
                                           onChange={(e) => setCountry(e.target.value)}/>
                                </div>
                            </div>
                            <div className="col-xl-6 col-lg-12 col-md-6">
                                <div className="form-inner">
                                    <label>Username</label>
                                    <input type="text" placeholder={user.username} readOnly/>
                                </div>
                            </div>
                            <div className="col-xl-6 col-lg-12 col-md-6">
                                <div className="form-inner">
                                    <label>Email Status</label>
                                    <input type="text" readOnly
                                           placeholder={user.email_verified_at ? 'Verified' : 'Not Verified'}/>
                                </div>
                            </div>
                            <div className="col-12">
                                <div className="button-group">
                                    <button type="submit" className="eg-btn profile-btn">Update Profile</button>
                                    <button className="eg-btn cancel-btn">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>)
}
