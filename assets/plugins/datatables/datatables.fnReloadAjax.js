$.fn.dataTableExt.oApi.fnReloadAjax = function(oSettings, sNewSource, myParams) {
            if (oSettings.oFeatures.bServerSide) {
//                if (typeof sNewSource != 'undefined' && sNewSource != null) {
//                    oSettings.sAjaxSource = sNewSource;
//                }
                oSettings.aoServerParams = [];
                oSettings.aoServerParams.push({
                    "fn": function(aoData) {
                        for (var index in myParams) {
                            aoData.push({"name": index, "value": myParams[index]});
                        }
                    }
                });
                this.fnClearTable(oSettings);
                return;
            }
        };

