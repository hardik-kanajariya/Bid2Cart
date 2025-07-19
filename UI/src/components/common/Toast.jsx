import React, { useEffect } from 'react';
import PropTypes from 'prop-types';

const Toast = ({ message, type = 'info', onClose, duration = 5000 }) => {
  useEffect(() => {
    const timer = setTimeout(() => {
      onClose();
    }, duration);

    return () => clearTimeout(timer);
  }, [onClose, duration]);

  const getToastClass = () => {
    switch (type) {
      case 'success':
        return styles.toastSuccess;
      case 'error':
        return styles.toastError;
      case 'warning':
        return styles.toastWarning;
      default:
        return styles.toastInfo;
    }
  };

  return (
    <div className={`${styles.toast} ${getToastClass()}`}>
      <div className={styles.toastContent}>
        <span className={styles.toastMessage}>{message}</span>
        <button 
          className={styles.toastClose}
          onClick={onClose}
          aria-label="Close notification"
        >
          ×
        </button>
      </div>
    </div>
  );
};

Toast.propTypes = {
  message: PropTypes.string.isRequired,
  type: PropTypes.oneOf(['success', 'error', 'warning', 'info']),
  onClose: PropTypes.func.isRequired,
  duration: PropTypes.number
};

export default Toast;