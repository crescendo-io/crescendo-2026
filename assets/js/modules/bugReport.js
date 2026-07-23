import markerSDK from '@marker.io/browser';

/* global ParamsData */
/* eslint-disable no-unused-vars */

export default bugReport => {
    // console.log('bugReport', bugReport, ParamsData.bug_report_id);
    (async () => {
        if (ParamsData.bug_report_id && ParamsData.bug_report_id !== '') {
            await markerSDK.loadWidget({
                destination: ParamsData.bug_report_id,
            });
        }
    })();
};
