# Juno_Imagecompress

Supported config:

enable/disable the module
image folder that need to optimize
server that handle the optimization


How it work: 

The optimization will be trigger nightly by magento cron. It collect image on specific folder (recuresive to its subfolder) and do optimize

The module does not optimize images myself, it send the image to external server and get the optimized version back, then the original image will be replaced by optimized version.

need more support ? contact hieu@junowebdesign.com

