@extends('salary.genrateSalaries')
@section('title', $salary_month.' | Genrate Salary')
@section('salary_month', $salary_month)

@section('salaryMonth')

  

         <thead>
                 <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Salary</th>
                  
                    <th>Lates</th>
                    <th>Late Fine</th>
                    <th>Overtime(mins)</th>
                    <th>Overtime Amount</th>
                    <th>Absent Deduction</th>
                    <th>Allowances</th>

                    
                    <th>Penality Charges</th>
                    <th>Total Salary</th>
                   
                    
                  </tr>

                  </thead>
                  
                  <tbody>
                  @if(isset($employees))
                    @foreach($employees as $emp)
                      
                        <tr>
                   
                     <td>{{$emp['employee']['id']}}</td>
                     <td>{{$emp['employee']['name']}}</td>
                     <td>{{$emp['employee']['salary']}}</td>
                     <td>{{$emp['profile']['month_late_comings_count']}}</td>
                    <td>{{$emp['profile']['month_late_comings_amount']}}</td>
                     <td>{{$emp['profile']['month_overtime_count']}}</td>
                     <td>{{$emp['profile']['month_overtime_amount']}}</td>
                     <td>{{$emp['profile']['monthly_leave_deduction']}}</td>
                     <td>{{$emp['profile']['allowance_amount']}}</td>
                      <td>{{$emp['profile']['penality_amount']}}</td>
                       
                    
                     <td>{{$emp['profile']['total_salary']}}</td>
                     
                    
                     
                     
                                       
                   </tr>

                    @endforeach

                  @endif

                  </tbody>

                   <tfoot>
                  <tr>
                  
                  </tr>
                  </tfoot>

@endsection