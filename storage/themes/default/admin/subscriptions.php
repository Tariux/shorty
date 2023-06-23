<div class="card flex-fill">
    <div class="card-header">
        <div class="d-flex">
            <div>
                <h5 class="card-title mb-0"><?php ee('Subscriptions') ?></h5>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th><?php ee('User') ?></th>                
                    <th><?php ee('Transaction ID') ?></th>
                    <th><?php ee('Payment Provider TID') ?></th>
                    <th><?php ee('Status') ?></th>
                    <th><?php ee('Amount') ?></th>
                    <th><?php ee('Date') ?></th>
                    <th><?php ee('Expiration') ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($subscriptions as $subscription): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="<?php echo $subscription->useravatar ?>" alt="" width="36" class="img-responsive rounded-circle">
                                <div class="ms-2">
                                    <a href="<?php echo route('admin.users.view', [$subscription->userid]) ?>"><?php echo $subscription->user ?></a>
                                    <?php if($subscription->user): ?>
                                        <a href="<?php echo route('admin.email', ['email' => $subscription->user]) ?>"><span class="badge bg-success"><?php ee('Send email') ?></span></a><br>
                                    <?php endif ?>
                                    <span class="badge bg-primary"><?php echo $subscription->plan ?></span>
                                </div>
                            </div>
                        </td>
                        <td><?php echo $subscription->uniqueid ?></td>
                        <td><?php echo $subscription->tid?:'NA' ?></td>                        
                        <td><?php echo $subscription->status ?> <?php echo $subscription->status == 'Canceled' && $subscription->reason ? '<i data-bs-toggle="tooltip" data-bs-placement="top" title="'.$subscription->reason.'" data-feather="help-circle"></i>' :'' ?></td>
                        <td><?php echo \Helpers\App::currency(config('currency'), $subscription->amount) ?></td>
                        <td><?php echo $subscription->date ?></td>
                        <td><?php echo $subscription->expiry ?></td>                        
                        <td>
                            <button type="button" class="btn btn-default shadow-lg bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                            <ul class="dropdown-menu">
                                <?php if($subscription->status !== 'Active'): ?>
                                    <li><a class="dropdown-item" href="<?php echo route('admin.subscription.markas', [$subscription->id, 'activate']) ?>"><i data-feather="check-circle"></i> <?php ee('Mark as Active') ?></a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.subscription.markas', [$subscription->id, 'cancel']) ?>"><i data-feather="x-circle"></i> <?php ee('Cancel') ?></a></li>
                                <?php endif ?>                        
                                <li><a class="dropdown-item" href="<?php echo route('admin.users.view', [$subscription->userid]) ?>"><i data-feather="user"></i> <?php ee('View User') ?></a></li>
                            </ul>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>    
    </div>
    <?php echo pagination('pagination') ?>
</div>
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php ee('Are you sure you want to cancel this?') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><?php ee('If you cancel the subscription, it will be canceled as for today. If you do not want to cancel it as of today leave it and it will automatically be canceled. if you proceed the user will be switched to a free plan right now.') ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
        <a href="#" class="btn btn-danger" data-trigger="confirm"><?php ee('Confirm') ?></a>
      </div>
    </div>
  </div>
</div>