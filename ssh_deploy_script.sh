#!/bin/bash

TARGET_VMS=(
  "192.168.1.15"
)

SSH_USER="v_auto"
SSH_KEY="/home/musharaf_manzoor/.ssh/v_auto_key"
PORTFOLIO_SCRIPT="/home/musharaf_manzoor/setup_portfolio.sh"

for ip in "${TARGET_VMS[@]}"; do
	echo " Starting deployment on VM $ip"

	# SSH connection
	# ssh -i "/home/musharaf_manzoor/.ssh/v_auto_key" v_auto@192.168.1.15
	ssh -o StrictHostKeyChecking=no -i "$SSH_KEY" "$SSH_USER@$ip" 'bash -s' < "$PORTFOLIO_SCRIPT"
        if [ $? -eq 0 ]; then
		echo "Success"
	else
		echo "Script failed"
	fi
done
